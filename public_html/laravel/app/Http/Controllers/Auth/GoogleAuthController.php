<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserInformation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoogleAuthController extends Controller
{
    // Google Giriş Yönlendirme
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Google Callback İşlemi
    public function handleGoogleCallback()
    {
        try {
            DB::beginTransaction();

            $googleUser = Socialite::driver('google')->user();

            // Kullanıcı email veya google_id ile var mı kontrol et
            $user = User::where('email', $googleUser->getEmail())
                ->orWhere('google_id', $googleUser->getId())
                ->first();

            $isNewUser = false;

            if (!$user) {
                // Yeni kullanıcı oluştur
                $user = User::create([
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password'  => Hash::make(str()->random(16)),
                    'user_type' => 'user',
                ]);

                // UserInformation oluştur
                UserInformation::create([
                    'name'    => $googleUser->getName(),
                    'user_id' => $user->id,
                ]);

                $isNewUser = true;
            } else {
                // Mevcut kullanıcıyı güncelle (google_id yoksa ekle)
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }

                // UserInformation yoksa oluştur
                if (!$user->informations) {
                    UserInformation::create([
                        'name'    => $googleUser->getName(),
                        'user_id' => $user->id,
                    ]);
                }
            }

            DB::commit();

            // Yeni kullanıcı oluşturulduysa event'i tetikle (hoşgeldin maili ve admin bildirimi için)
            if ($isNewUser) {
                event(new Registered($user));
            }

            // Kullanıcıyı giriş yaptır
            Auth::login($user);

            return redirect('/')
                ->withSuccess('Google ile giriş başarılı! Hoş geldiniz.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('/')
                ->withError('Google ile giriş yapılamadı: ' . $e->getMessage());
        }
    }
}
