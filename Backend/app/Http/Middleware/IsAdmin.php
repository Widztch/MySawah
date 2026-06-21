<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login DAN rolenya adalah admin
        if ($request->user() && $request->user()->role === 'admin') {
            return $next($request); // Silakan masuk
        }

        // Jika bukan admin, tolak dengan error 403 (Forbidden)
        return response()->json([
            'status' => 'error',
            'message' => 'Akses ditolak! Anda bukan Admin.'
        ], 403);
    }
}