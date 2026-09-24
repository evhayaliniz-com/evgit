<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewMessageMail;
use App\Models\Category;
use App\Models\Company;
use App\Models\EmailVerification;
use App\Models\Follower;
use App\Models\PackagePurchase;
use App\Models\ProPackage;
use App\Models\Report;
use App\Models\Service;
use App\Models\User;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;
use App\Traits\NotificationTrait;
use App\Traits\EmailTemplateTrait;

class CompanyController extends Controller
{
    use NotificationTrait, EmailTemplateTrait;

    public function index($status = null)
    {
        $companies = Company::query();

        if (request()->category) {
            $companies = $companies->where('category_id', request()->category);
        }

        if (request()->sub_category) {
            $companies = $companies->where('sub_category_id', request()->sub_category);
        }

        if (request()->pro_package) {
            $companyPackages = PackagePurchase::active()->where('pro_package_id', request()->pro_package)->get()
                ->pluck('company_id')->toArray();
            $companies = $companies->whereIn('id', $companyPackages);
        }

        // Durum değeri varsa denk gelen verileri çekiyoruz, yoksa tüm verileri çekiyoruz
        if ($status) {
            $status = $status == 'passive' ? 0 : 1;
            $companies = $companies->where('status', $status);
        }

        $companyCount = $companies->count();
        $companies = $companies->orderByDesc('id')->paginate(20)->withQueryString();

        $subCategories = Category::whereNotNull('parent_id')->where('status', 1)->get();

        $packages = ProPackage::active()->orderByDesc('id')->get();

        return view('admin.companies.index', compact('companyCount', 'companies', 'subCategories', 'packages'));
    }


    // Firmanın durumunu aktif veya pasif olarak düzenliyoruz.
    public function status($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $status = $user->status == 1 ? 0 : 1;
        $user->status = $status;
        $user->save();
        Company::where('user_id', $id)->update(['status' => $status]);

        return redirect()->back()->withSuccess('İşlem tamamlandı.');
    }


    // Firmanın aktif olarak bir paketi varsa ekstra kullanım hakkı ekliyoruz.
    public function addExtraRight($id, Request $request)
    {
        $request->validate([
            'pro_package_id' => ['required', 'exists:pro_packages,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'right' => ['nullable', 'numeric', 'min:0'],
            'end_date' => ['nullable', 'date', 'after:today']
        ]);

        // Firmanın kullanım hakkını belirtilen değer kadar arttırıyoruz.
        // extra_right alanına gönderilen değeri ekliyoruz.
        // Paketin toplam kullanım hakkını belirtilen değer kadar arttırıyoruz.

        // Eğer end_date gönderilmemişse 30 gün sonrası default olarak atanır
        $endDate = $request->end_date ? $request->end_date : now()->addDays(30);

        $package = PackagePurchase::active()->where('pro_package_id', $request->pro_package_id)->where('company_id', $id)
            ->where('category_id', $request->category_id)->first();

        if ($package) {
            $package->remaining_rights += $request->right;
            $package->extra_right = $request->right;
            $package->total_rights += $request->right;
            // Eğer end_date belirtilmişse onu kullan, yoksa mevcut end_date'i koru
            if ($request->end_date) {
                $package->end_date = $endDate;
            }
            $package->save();

        } else {
            $package = \App\Models\ProPackageCategory::active()->where('pro_package_id', $request->pro_package_id)
                ->where('category_id', $request->category_id)->firstOrFail();

            PackagePurchase::create([
                'company_id' => $id,
                'pro_package_id' => $request->pro_package_id,
                'category_id' => $request->category_id,
                'price' => 0,
                'used_rights' => 0,
                'remaining_rights' => $request->right ? $package->rights + (int)$request->right : $package->rights,
                'extra_right' => (int)$request->right,
                'total_rights' => $request->right ? $package->rights + (int)$request->right : $package->rights,
                'type' => 'monthly',
                'duration' => 30,
                'start_date' => now(),
                'end_date' => $endDate,
                'merchant_oid' => null,
                'status' => 1,
            ]);
        }

        return redirect()->back()->withSuccess('İşlem tamamlandı.');
    }


    // Paket düzenleme
    public function editPackage($packageId, Request $request)
    {
        $request->validate([
            'pro_package_id' => ['required', 'exists:pro_packages,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'total_rights' => ['required', 'numeric', 'min:0'],
            'end_date' => ['nullable', 'date']
        ]);

        $package = PackagePurchase::findOrFail($packageId);
        
        // Kalan hakları yeniden hesapla (kullanılan hak - yeni toplam hak)
        $usedRights = $package->used_rights;
        $newRemainingRights = max(0, $request->total_rights - $usedRights);
        
        $package->update([
            'pro_package_id' => $request->pro_package_id,
            'category_id' => $request->category_id,
            'total_rights' => $request->total_rights,
            'remaining_rights' => $newRemainingRights,
            'end_date' => $request->end_date ?: $package->end_date,
        ]);

        return redirect()->back()->withSuccess('Paket başarıyla güncellendi.');
    }


    // Paket silme
    public function deletePackage($packageId)
    {
        $package = PackagePurchase::findOrFail($packageId);
        $package->delete();

        return redirect()->back()->withSuccess('Paket başarıyla silindi.');
    }


    public function create()
    {
        return view('admin.company.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies',
            'password' => 'required|min:6',
            'tax_number' => 'required|unique:companies',
        ]);

        Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'fixed_phone' => $request->fixed_phone,
            'mobile_phone' => $request->mobile_phone,
            'tax_number' => $request->tax_number,
            'about' => $request->about,
            'province' => $request->province,
            'district' => $request->district,
            'address' => $request->address,
            'map_location' => $request->map_location,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'website' => $request->website,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.companies.index')->with('success', 'Firma başarıyla eklendi.');
    }

    public function edit(Company $company)
    {
        return view('admin.company.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:companies,email,$company->id",
            'tax_number' => "required|unique:companies,tax_number,$company->id",
        ]);

        $company->update([
            'name' => $request->name,
            'slug' => str()->slug($request->name) . '-' . $company->id,
            'email' => $request->email,
            'fixed_phone' => $request->fixed_phone,
            'mobile_phone' => $request->mobile_phone,
            'tax_number' => $request->tax_number,
            'about' => $request->about,
            'province' => $request->province,
            'district' => $request->district,
            'address' => $request->address,
            'map_location' => $request->map_location,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'website' => $request->website,
            'is_completed' => 1
        ]);

        return redirect()->route('admin.companies.index')->with('success', 'Firma başarıyla güncellendi.');
    }


    // Onaylı Firma İşlemi
    public function verifyCompany($id, $status)
    {
        $company = Company::findOrFail($id);

        // Firma durumunu güncelliyoruz.
        $company->is_verified = $status;
        $company->save();

        return redirect()->back()->withSuccess('İşlem Tamamlandı.');
    }


    public function profileDestroy()
    {
        // Kullanıcı ile ilgili verileri siliyoruz.
        try {
            DB::beginTransaction();

            $id = auth()->user()->id;
            $companyId = auth()->user()->company->id;
            $userEmail = auth()->user()->email;
            
            // Servis ile ilgili bilgileri silebilmek için firmaya ait olan servisleri id değerini çekiyoruz.
            $serviceIds = \App\Models\Service::select('id')->where('company_id', $companyId)->get()->pluck('id')->toArray();
            
            // Takip bilgilerini siliyoruz.
            \App\Models\Follower::where('user_id', $id)->orWhere('to_id', $id)->delete();
            // Fikirlere yapılan yorumları siliyoruz.
            \App\Models\IdeaReply::where('user_id', $id)->delete();
            // Fikirlere yapılan yorum beğenilerini siliyoruz.
            \App\Models\IdeaReplyLike::where('user_id', $id)->delete();
            // Fikir beğenilerini siliyoruz.
            \App\Models\IdeaLike::where('user_id', $id)->delete();
            // Mesajları siliyoruz.
            \App\Models\Message::where('sender_id', $id)->orWhere('receiver_id', $id)->delete();
            // Şikayetleri siliyoruz.
            \App\Models\Report::where('user_id', $id)->delete();
            // Servisleri siliyoruz.
            \App\Models\Service::where('company_id', $companyId)->delete();
            // Servislerin resimlerini siliyoruz.
            \App\Models\ServiceImage::whereIn('service_id', $serviceIds)->delete();
            // Servislerin sorularını siliyoruz.
            \App\Models\ServiceQuestion::whereIn('service_id', $serviceIds)->delete();
            // Servislerin kayıtlılarını siliyoruz.
            \App\Models\ServiceSaved::whereIn('service_id', $serviceIds)->delete();
            // Servislere firmanın yazdığı soruları siliyoruz.
            \App\Models\ServiceQuestion::where('user_id', $id)->delete();
            // Profile kayıt edilen servislerin değerlerini siliyoruz.
            \App\Models\ServiceSaved::where('user_id', $id)->delete();
            // Bildirimleri siliyoruz (hem gönderen hem alan olarak)
            \App\Models\Notification::where('user_id', $id)->orWhere('to_id', $id)->delete();
            // E-posta doğrulama kodlarını siliyoruz.
            \App\Models\EmailVerification::where('email', $userEmail)->delete();
            // Paket satın alma kayıtlarını siliyoruz.
            \App\Models\PackagePurchase::where('company_id', $companyId)->delete();
            // Firma değerlendirmelerini siliyoruz.
            \App\Models\CompanyRating::where('company_id', $companyId)->delete();
            // Firma bilgilerini siliyoruz.
            \App\Models\Company::where('user_id', $id)->delete();
            // Hesabı siliyoruz.
            \App\Models\User::whereId($id)->delete();
            
            // Session'ı temizle (veriler silindikten sonra)
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            
            DB::commit();
            return redirect('/');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withError('İşlem sırasında bir hata oluştu. Lütfen tekrar deneyin');
        }
    }


    /********************* KULLANICI İŞLEMLERİ ********************/

    public function sendVerify()
    {
        /* is_verified değerleri
         * 0: normal firma
         * 1: onaylı firma
         * 2: istek gönderen firma
         * */


        $isVerified = auth()->user()->company->is_verified;

        if ($isVerified == 2) {
            return redirect()->back()->withError('Göndermiş olduğunuz istek henüz sonuçlanmadığı için yeni bir istek
            gönderilemiyor.');
        }

        // is_verified değerini istek gönderen olarak güncelliyoruz.
        Company::where('user_id', auth()->user()->id)->where('status', 1)->where('is_verified', 0)->update(['is_verified' => 2]);


        // Admin hesaplarına mail gönderiyoruz.
        foreach (User::where('user_type', 'admin')->get() as $admin) {
            Mail::send('emails.template', ['msg' => auth()->user()->email . " E-posta adresine sahip firma
                tarafından onaylı firma olma isteği gönderilmiştir."], function ($message) use ($admin) {
                $message->to($admin->email)->subject('Onaylı Firma İsteği Gönderildi');
            });
        }

        return redirect()->back()->withSuccess('Başvurunuz iletilmiştir. En kısa sürede tarafınız ile iletişime geçilecektir.');
    }


    public function profileEdit()
    {
        $company = auth()->user()->company;
        return view('site.company.edit', compact('company'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'name' => ['required', 'string', 'max:190'],
            'authorized' => ['required', 'string', 'max:190'],
            'mobile_phone' => ['required'],
            'tax_number' => ['required'],
            'about' => ['required'],
            'province' => ['required', 'numeric'],
            'district' => ['required', 'numeric'],
            'address' => ['required', 'string'],
            'category_id' => ['required', 'numeric'],
            'sub_category_id' => ['required', 'numeric'],
        ]);


        $companyInformations = auth()->user()->company;

        // sabit telefon, telefon numarası, veya vergi numarası sistemde farklı bir kullanıcı tarafından kullanılıyor mu kontrol ediyoruz.
        // Eğer kullanılıyorsa kullanıcıya hata mesajı döndürüyoruz
        $phoneOrFaxExists = Company::where('user_id', '!=', auth()->user()->id)->where(function ($q) use ($request) {
            if ($request->fixed_phone) {
                $q->where('fixed_phone', $request->fixed_phone);
                $q->orWhere('fixed_phone', $request->mobile_phone);
                $q->orWhere('mobile_phone', $request->fixed_phone);
            }
            $q->orWhere('mobile_phone', $request->mobile_phone);
            $q->orWhere('tax_number', $request->tax_number);
        })->first();


        if ($phoneOrFaxExists) {
            $errorMessage = 'Sabit telefon, telefon numarası veya vergi no sistemde farklı bir hesap tarafından kullanılıyor. Lütfen bilgilerinizi tekrar kontrol ediniz.';
            if ($request->expectsJson()) {
                return response()->json(['message' => $errorMessage], 422);
            }
            return redirect()->back()->withInput()->withError($errorMessage);
        }


        if ($request->hasFile('avatar') && $request->remove_avatar == 1) {
            $file = $request->file('avatar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('site/images/avatars', $fileName);
            $fileName = 'site/images/avatars/' . $fileName;
        }

        // remove_avatar değeri 2 ise fotoğrafı kaldırıyoruz.
        if ($request->remove_avatar == 2) {
            $fileName = 'site/images/default_avatar.jpg';
        }

        Company::where('user_id', auth()->user()->id)->update([
            'avatar' => isset($fileName) ? $fileName : auth()->user()->company->avatar,
            'name' => $request->name,
            'authorized' => $request->authorized,
            'fixed_phone' => $request->fixed_phone,
            'mobile_phone' => $request->mobile_phone,
            'tax_number' => $request->tax_number,
            'about' => $request->about,
            'province' => $request->province,
            'district' => $request->district,
            'address' => $request->address,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'website' => $request->website,
            'is_completed' => 1
        ]);

        $successMessage = 'Profil bilgileriniz başarıyla güncellendi.';
        
        $company = auth()->user()->company->fresh();

        if ($request->filled('redirect') && $company->is_completed) {
            $redirectUrl = urldecode($request->input('redirect'));
            if ($request->expectsJson()) {
                return response()->json(['message' => $successMessage, 'redirect' => $redirectUrl]);
            }
            return redirect($redirectUrl)->withSuccess($successMessage);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $successMessage,
                'avatar_url' => asset($company->avatar)
            ]);
        }

        return redirect()->back()->withSuccess($successMessage);
    }

    public function companiesIndex(Request $request)
    {
        $companies = Company::query()->withCount(['ratings as average_rating' => function($query) {
            $query->select(DB::raw('coalesce(avg(rating), 0)'));
        }]);


        // Filtreleme işlemleri
        if ($request->category) {
            $companies = $companies->where('category_id', $request->category);
        }

        if ($request->sub_category) {
            $companies = $companies->where('category_id', $request->category)->where('sub_category_id', $request->sub_category);
        }

        if ($request->province) {
            $companies = $companies->where('province', $request->province);
        }

        if ($request->district) {
            $companies = $companies->where('province', $request->province)->where('district', $request->district);
        }

        if ($request->q) {
            $companies = $companies->where('name', 'LIKE', '%' . $request->q . '%');
        }

        $companyCount = $companies->active()->count();
        $companies = $companies->active()
            ->with(['ratings', 'provinceInfo', 'districtInfo', 'category', 'subCategory'])
            ->orderByDesc('id')
            ->paginate(16);

        return view('site.company.index', compact('companyCount', 'companies'));
    }


    public function companyShow(Request $request, $slug)
    {
        $company = Company::active()->where('slug', $slug)->firstOrFail();

        // Giriş yapan kullanıcının ip adresinden görüntülenme almamışsa profil görüntülenme değeri için ip adresini
        // veritabanına kayıt ediyoruz.
        View::firstOrCreate(['ip' => request()->ip(), 'to_id' => $company->id, 'type' => 'profile']);

        $services = Service::query();

        switch ($request->order_by) {
            case 'price_asc':
                $services = $services->orderBy('price', 'ASC');
                break;

            case 'price_desc':
                $services = $services->orderByDesc('price');
                break;

            case 'date_desc':
                $services = $services->orderByDesc('created_at');
                break;

            case 'date_asc':
                $services = $services->orderBy('created_at', 'ASC');
                break;
        }

        // Servisleri ve toplam servis sayısını alıyoruz.
        $services = $services->active()->where('company_id', $company->id)->orderByDesc('id');
        $serviceCount = $services->count();
        $services = $services->paginate(20)->withQueryString();

        return view('site.company.show', compact('company', 'serviceCount', 'services'));
    }


    public function follow(Request $request)
    {
        $status = $request->status ?? 1;

        // Firmanın varlığını kontrol ediyoruz.
        $user = Crypt::decryptString($request->user);
        $user = User::active()->whereId($user)->firstOrFail();

        // Takip etmiyorsa takip verisini oluşturuyoruz, ediyorsa siliyoruz.
        $followExists = $status == 1 ? Follower::where('user_id', auth()->user()->id)->where('to_id', $user->id)->first()
            : Follower::where('user_id', $user->id)->where('to_id', auth()->user()->id)->first();

        if (!$followExists) {
            if ($status == 1) {
                Follower::create(['user_id' => auth()->user()->id, 'to_id' => $user->id]);

            } else {
                Follower::create(['user_id' => $user->id, 'to_id' => auth()->user()->id]);
            }

            $this->notification('follow', $user->id);

            // Mail gönder
            $this->triggerEmailTemplate('follow', $user, [
                'follower_name' => auth_info()->name,
            ]);

            return redirect()->back()->withSuccess('Takip edildi.');

        } else {
            $followExists->delete();
            return redirect()->back()->withSuccess('Takipten çıkarıldı.');
        }
    }


    // Sikayet Oluşturma
    public function report($slug, Request $request)
    {
        // Bir kullanıcı firma hakkında aktif olarak sadece 1 adet şikayet oluşturabilir.
        // Aktif olan şikayeti var mı kontrol ediyoruz. Yoksa oluşturuyoruz, varsa bilgilendirme mesajını döndürüyoruz.
        // status değerleri: 0 - aktif, 1 - çözümlenmiş

        $request->validate(['message' => ['required', 'string', 'max:5000']]);

        // Servisin varlığını kontrol ediyoruz.
        $company = Company::active()->where('slug', $slug)->firstOrFail();
        // Aktif olan bir şikayet var mı kontrol ediyoruz.
        $reportExists = Report::where('user_id', auth()->user()->id)->where('to_id', $company->id)->where('type', 'company')
            ->where('status', 0)->first();

        if (!$reportExists) {
            // Aktif şikayet yoksa oluşturuyoruz.
            Report::create([
                'message' => $request->message,
                'user_id' => auth()->user()->id,
                'to_id' => $company->id,
                'type' => 'company',
                'status' => 0
            ]);

            return redirect()->back()->withSuccess('Şikayetiniz tarafımıza ulaşmıştır.');

        } else {
            // Aktif şikayet varsa bilgilendirme mesajı döndürüyoruz.
            return redirect()->back()->withError('Firma üzerinde aktif olarak iletmiş olduğunuz bir şikayet konusu olduğu
            için yeni bir şikayet gönderilemiyor.');
        }
    }
}


