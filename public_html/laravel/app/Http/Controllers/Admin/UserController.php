<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class UserController extends Controller
{
    /********************* ADMİN İŞLEMLERİ ********************/

    public function index($status = null)
    {
        // Durum değeri varsa denk gelen verileri çekiyoruz, yoksa tüm verileri çekiyoruz
        if ($status) {
            $status = $status == 'passive' ? 0 : 1;
            $users = UserInformation::where('status', $status)->orderByDesc('id')->paginate(20);

        } else {
            $users = UserInformation::orderByDesc('id')->paginate(20);
        }

        return view('admin.users.index', compact('users'));
    }

    public function status($id)
    {
        $user = User::findOrFail($id);
        $status = $user->status == 1 ? 0 : 1;
        $user->status = $status;
        $user->save();
        UserInformation::where('user_id', $id)->update(['status' => $status]);

        return redirect()->back()->withSuccess('İşlem tamamlandı.');
    }


    public function destroy()
    {
        // Kullanıcı ile ilgili verileri siliyoruz.
        try {
            DB::beginTransaction();

            $id = auth()->user()->id;
            $userEmail = auth()->user()->email;
            
            // Takip bilgilerini siliyoruz.
            \App\Models\Follower::where('user_id', $id)->orWhere('to_id', $id)->delete();
            // Kullanıcının oluşturduğu fikirleri siliyoruz.
            $ideaIds = \App\Models\Idea::where('user_id', $id)->pluck('id')->toArray();
            // Fikir beğenilerini siliyoruz (kullanıcının beğendiği fikirler).
            \App\Models\IdeaLike::where('user_id', $id)->delete();
            // Fikirlere yapılan yorumları siliyoruz.
            \App\Models\IdeaReply::where('user_id', $id)->delete();
            // Fikirlere yapılan yorum beğenilerini siliyoruz.
            \App\Models\IdeaReplyLike::where('user_id', $id)->delete();
            // Kullanıcının oluşturduğu fikirlerin beğenilerini siliyoruz.
            if (!empty($ideaIds)) {
                \App\Models\IdeaLike::whereIn('idea_id', $ideaIds)->delete();
                // Fikirlerin yorumlarını siliyoruz.
                $replyIds = \App\Models\IdeaReply::whereIn('idea_id', $ideaIds)->pluck('id')->toArray();
                if (!empty($replyIds)) {
                    \App\Models\IdeaReplyLike::whereIn('reply_id', $replyIds)->delete();
                }
                \App\Models\IdeaReply::whereIn('idea_id', $ideaIds)->delete();
                // Fikirleri siliyoruz.
                \App\Models\Idea::where('user_id', $id)->delete();
            }
            // Mesajları siliyoruz.
            \App\Models\Message::where('sender_id', $id)->orWhere('receiver_id', $id)->delete();
            // Şikayetleri siliyoruz.
            \App\Models\Report::where('user_id', $id)->delete();
            // Servis sorularını siliyoruz.
            \App\Models\ServiceQuestion::where('user_id', $id)->delete();
            // Profile kayıt edilen servislerin değerlerini siliyoruz.
            \App\Models\ServiceSaved::where('user_id', $id)->delete();
            // Bildirimleri siliyoruz (hem gönderen hem alan olarak)
            \App\Models\Notification::where('user_id', $id)->orWhere('to_id', $id)->delete();
            // E-posta doğrulama kodlarını siliyoruz.
            \App\Models\EmailVerification::where('email', $userEmail)->delete();
            // Kullanıcının verdiği firma değerlendirmelerini siliyoruz.
            \App\Models\CompanyRating::where('user_id', $id)->delete();
            // Kullanıcı bilgilerini siliyoruz.
            \App\Models\UserInformation::where('user_id', $id)->delete();
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

    public function edit()
    {
        $user = auth()->user()->informations;
        return view('site.users.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'name' => ['required', 'string', 'max:190'],
            'category_id' => ['nullable', 'numeric'],
            'sub_category_id' => ['nullable', 'numeric'],
        ]);

        $userInformations = auth()->user()->informations;

        if ($request->hasFile('avatar') && $request->remove_avatar == 1) {
            // Eski görsel varsa sil
//            if ($userInformations->avatar && \Storage::disk('public')->exists($userInformations->avatar)) {
//                \Storage::disk('public')->delete($userInformations->avatar);
//            }

            // Yeni görseli yükle
//            $fileName = $request->file('avatar')->store('avatars', 'public');

            $file = $request->file('avatar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move('site/images/avatars', $fileName);
            $fileName = 'site/images/avatars/' . $fileName;
        }


        // remove_avatar değeri 2 ise fotoğrafı kaldırıyoruz.
        if ($request->remove_avatar == 2) {
            $fileName = 'site/images/default_avatar.jpg';
        }

        UserInformation::where('user_id', auth()->user()->id)->update(['avatar' => isset($fileName) ? $fileName
            : auth()->user()->informations->avatar, 'name' => $request->name, 'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id]);

        return redirect()->back()->withSuccess('İşlem tamamlandı.');
    }
}
