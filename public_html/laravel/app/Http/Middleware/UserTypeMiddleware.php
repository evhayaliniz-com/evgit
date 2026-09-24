<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTypeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , string $user_type): Response
    {
      // dd($request->user()->user_type  );
        //return $next($request);
        if ($request->user()->user_type === $user_type ) {
            return $next($request);
        }
        return redirect()->route('dashboard');
    }
}
