<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPassword
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('admin_verified')) {
            return redirect()->route('dashboard')
                ->with('error', 'Please verify admin password first.');
        }

        $verifiedAt = session('admin_verified_at');
        if ($verifiedAt && now()->diffInMinutes($verifiedAt) > 5) {
            session()->forget(['admin_verified', 'admin_verified_at']);
            return redirect()->route('dashboard')
                ->with('error', 'Admin verification expired. Please verify again.');
        }

        return $next($request);
    }
}