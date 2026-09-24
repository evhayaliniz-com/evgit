<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserInformation;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class FacebookAuthController extends Controller
{
    // Facebook Giriş Yönlendirme
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    // Facebook Callback İşlemi
    public function handleFacebookCallback()
    {
        try {
            DB::beginTransaction();

            $facebookUser = Socialite::driver('facebook')->user();

            // Kullanıcı email veya facebook_id ile var mı kontrol et
            $user = User::where('email', $facebookUser->getEmail())
                ->orWhere('facebook_id', $facebookUser->getId())
                ->first();

            $isNewUser = false;

            if (!$user) {
                // Yeni kullanıcı oluştur
                $user = User::create([
                    'email'       => $facebookUser->getEmail(),
                    'facebook_id' => $facebookUser->getId(),
                    'password'    => Hash::make(str()->random(16)),
                    'user_type'   => 'user',
                ]);

                // UserInformation oluştur
                UserInformation::create([
                    'name'    => $facebookUser->getName(),
                    'user_id' => $user->id,
                ]);

                $isNewUser = true;
            } else {
                // Mevcut kullanıcıyı güncelle (facebook_id yoksa ekle)
                if (!$user->facebook_id) {
                    $user->update(['facebook_id' => $facebookUser->getId()]);
                }

                // UserInformation yoksa oluştur
                if (!$user->informations) {
                    UserInformation::create([
                        'name'    => $facebookUser->getName(),
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
                ->withSuccess('Facebook ile giriş başarılı! Hoş geldiniz.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect('/')
                ->withError('Facebook ile giriş yapılamadı: ' . $e->getMessage());
        }
    }
}
