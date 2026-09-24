<?php

namespace App\Http\Controllers;

use App\Mail\AdminContactMessageNotification;
use App\Models\Contact;
use App\Models\Setting;
use App\Traits\AdminNotificationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    use AdminNotificationTrait;
    /************************* ADMIN İŞLEMLERİ *************************/

    public function adminIndex()
    {
        $contacts = Contact::orderByDesc('id')->paginate(10);
        return view('admin.contact.index', compact('contacts'));
    }

    public function destroy(string $id)
    {
        Contact::whereId($id)->delete();
        return redirect()->route('admin.contacts.index')->withSuccess('İşlem Tamamlandı.');
    }

    /************************* KULLANICI İŞLEMLERİ *************************/

    public function index()
    {
        $settings = Setting::first();
        return view('site.contact.index', compact('settings'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'g-recaptcha-response' => ['required'],
        ]);

        // reCAPTCHA doğrulaması
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $recaptchaResponse,
            'remoteip' => $request->ip(),
        ]);

        $responseData = $response->json();

        if (!$responseData['success']) {
            return redirect()->back()
                ->withInput()
                ->withError('Robot doğrulaması başarısız. Lütfen tekrar deneyin.');
        }

        try {
            DB::beginTransaction();

            // İletişim mesajını kaydediyoruz.
            $contact = Contact::create($request->only(['name', 'email', 'phone_number', 'message']));

            $this->notifyAdmins(new AdminContactMessageNotification($contact));

            $summary = (string) Str::of($contact->message ?? '')
                ->squish()
                ->limit(80);

            $this->createAdminNotifications(
                'Yeni iletişim mesajı: ' . $summary,
                route('admin.contacts.index'),
                0
            );

            DB::commit();

            return redirect()
                ->route('contact.index')
                ->withSuccess('İletişim mesajı gönderildi.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->withError('İşlem sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }
}
