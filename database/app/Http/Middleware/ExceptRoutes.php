<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ExceptRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $except = [
            'login',
            'register',
            'password/reset',
            'password/email',
            // Agrega más rutas aquí según sea necesario
        ];

        foreach ($except as $route) {
            if ($request->is($route)) {
                return $next($request);
            }
        }

        if (Auth::check()) {
            return $next($request);
        }

        return redirect()->route('dashboard');
    }
}