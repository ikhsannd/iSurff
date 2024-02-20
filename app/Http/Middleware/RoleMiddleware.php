<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Cek apakah pengguna telah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil peran pengguna saat ini
        $userRole = Auth::user()->role_id;

        // Cek apakah peran pengguna termasuk dalam daftar peran yang diizinkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
