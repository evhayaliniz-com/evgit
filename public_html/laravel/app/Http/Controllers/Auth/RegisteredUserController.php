<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Models\UserInformation;
use App\Models\EmailVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        if (in_array($request->user_type, ['user', 'company'])) {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
                'register_checkbox' => ['required'],
                'verification_code' => ['required', 'string', 'size:6'],
            ]);

            // E-posta adresinin varlığını kontrol ediyoruz.
            if(User::where('email', $request->email)->first()) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Girmiş olduğunuz e-posta adresi farklı bir kullanıcı tarafından kullanılıyor.'
                    ], 422);
                }

                return redirect()->back()->withError('Girmiş olduğunuz e-posta adresi farklı bir kullanıcı tarafından kullanılıyor.');
            }

            // Doğrulama kodunu kontrol et
            $verification = EmailVerification::where('email', $request->email)
                ->where('code', $request->verification_code)
                ->where('expires_at', '>', Carbon::now())
                ->first();

            if (!$verification) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Girilen kod hatalı veya süresi dolmuş! Lütfen e-posta adresinize gelen doğru kodu girin.'
                    ], 422);
                }

                return redirect()->back()
                    ->withInput()
                    ->withError('Girilen kod hatalı veya süresi dolmuş! Lütfen e-posta adresinize gelen doğru kodu girin.');
            }

            // Kod doğru, kaydı sil
            $verification->delete();

            $user = User::create([
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
            ]);


            // Kayıt işlemini yapan firmaysa kategori ve alt kategori değerlerini doğrulayıp, Firmayı oluşturuyoruz
            if ($request->user_type == 'company') {
                $request->validate([
                    'category_id' => ['required', 'numeric'],
                    'sub_category_id' => ['required', 'numeric']
                ]);

                $company = Company::create([
                    'name' => $request->name,
                    'user_id' => $user->id,
                    'category_id' => $request->category_id,
                    'sub_category_id' => $request->sub_category_id
                ]);

                Company::whereId($company->id)->update(['slug' => str()->slug($request->name).'-'.$company->id]);

            } else {
                // Kullanıcı bilgilerini oluşturuyoruz
                UserInformation::create([
                    'name' => $request->name,
                    'user_id' => $user->id,
                ]);
            }

            $user->user_type = $request->user_type == 'user' ? 'user' : 'company';
            $user->save();

            event(new Registered($user));

            Auth::login($user);

            $redirectUrl = route('dashboard', absolute: false);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Kayıt işlemi başarılı.',
                    'redirect' => $redirectUrl,
                ]);
            }

            return redirect($redirectUrl);

        } else {
            return redirect()->back();
        }
    }
}
