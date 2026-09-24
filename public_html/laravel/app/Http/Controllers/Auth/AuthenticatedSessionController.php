<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse|JsonResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $redirectUrl = $request->input('redirect');

        if (! $redirectUrl) {
            if (auth()->user()->user_type === 'admin') {
                $redirectUrl = route('admin.dashboard.index');
            } elseif (auth()->user()->user_type === 'user') {
                $redirectUrl = route('user.dashboard');
            } else {
                $redirectUrl = route('company.profile.edit');
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Giriş başarılı.',
                'redirect' => $redirectUrl,
            ]);
        }

        if ($request->filled('redirect')) {
            return redirect()->to($redirectUrl);
        }

        return redirect()->intended($redirectUrl);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
