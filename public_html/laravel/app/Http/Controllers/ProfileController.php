<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    // Kullanıcı şifre değiştirme ekranı
    public function userPasswordEdit()
    {
        return view('site.users.change-password');
    }

    // Firma şifre değiştirme ekranı
    public function companyPasswordEdit()
    {
        return view('site.company.change-password');
    }


    public function passwordUpdate(Request $request)
    {
        // Gelen veriyi doğrula
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Eski şifreyi kontrol et
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Şu anki şifre yanlış.']);
        }

        // Şifreyi güncelle
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->withSuccess('Şifreniz başarıyla güncellendi!');
    }
}
