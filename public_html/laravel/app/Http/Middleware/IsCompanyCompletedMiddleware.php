<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCompanyCompletedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Firmanın bilgilerinin tamamı eklenmemişse firma işlemlerini yapmasını engelliyoruz.
        // Bilgilerini ekleyebilmesi için profil düzenleme sayfasına yönlendiriyoruz.
        if (auth()->user()->company->is_completed == 0) {
            // Mevcut URL'yi alıp, redirect parametresi olarak profil düzenleme sayfasına ekliyoruz.
            $redirectUrl = route('company.profile.edit', ['redirect' => urlencode($request->fullUrl())]);
            
            return redirect($redirectUrl)->withError('Hizmet ekleyebilmek için önce firma bilgilerinizi eksiksiz doldurmalısınız.');
        }

        return $next($request);
    }
}
