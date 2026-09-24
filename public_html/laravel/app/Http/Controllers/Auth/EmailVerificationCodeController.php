<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;

class EmailVerificationCodeController extends Controller
{
    /**
     * Doğrulama kodu gönder
     */
    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        try {
            // E-posta adresi zaten kayıtlı mı kontrol et
            $userExists = \App\Models\User::where('email', $request->email)->exists();

            if ($userExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bu e-posta adresi zaten kullanımda!'
                ], 422);
            }

            // Rastgele 6 haneli kod oluştur
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Eski kodları sil
            EmailVerification::where('email', $request->email)->delete();

            // Yeni kod kaydet (10 dakika geçerli)
            EmailVerification::create([
                'email' => $request->email,
                'code' => $code,
                'expires_at' => Carbon::now()->addMinutes(10)
            ]);

            // Mail gönder
            Mail::to($request->email)->send(new VerificationCodeMail($code, $request->email));

            return response()->json([
                'success' => true,
                'message' => 'Doğrulama kodu e-posta adresinize gönderildi.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kod gönderilirken bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Doğrulama kodunu kontrol et
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6'
        ]);

        try {
            $verification = EmailVerification::where('email', $request->email)
                ->where('code', $request->code)
                ->where('expires_at', '>', Carbon::now())
                ->first();

            if (!$verification) {
                return response()->json([
                    'success' => false,
                    'message' => 'Geçersiz veya süresi dolmuş kod!'
                ], 422);
            }

            // Kod doğru, kaydı sil
            $verification->delete();

            return response()->json([
                'success' => true,
                'message' => 'E-posta adresiniz doğrulandı!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Kod doğrulanırken bir hata oluştu: ' . $e->getMessage()
            ], 500);
        }
    }
}
