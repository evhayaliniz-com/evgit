<?php 


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (auth()->check() && auth()->user()->user_type !== $role) {
            abort(403, 'Bu bölüme erişim yetkiniz yok.');
        }

        return $next($request);
    }
}
