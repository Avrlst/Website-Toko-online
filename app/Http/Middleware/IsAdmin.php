<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
    

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek is_admin == 1
    if (Auth::check() && Auth::user()->is_admin == 1) {
            return $next($request);
        }
        
        // Jika bukan admin, lempar kembali ke beranda dengan pesan error
        return redirect('/')->with('error', 'Anda tidak memiliki akses admin.');
    }
}
