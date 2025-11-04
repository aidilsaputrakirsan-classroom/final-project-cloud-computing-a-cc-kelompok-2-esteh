<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silahkan login dulu.');
        }

        if (Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak punya akses sebagai admin.');
        }

        return $next($request);
    }
}
