<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PanitiaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek: Harus login & Role harus 'panitia'
        if (!auth()->check() || auth()->user()->role !== 'panitia') {
            abort(403, 'Akses Ditolak. Halaman ini khusus Panitia.');
        }

        return $next($request);
    }
}