<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user && $user->status !== 'approved') {
            auth()->logout();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda berstatus ' . $user->status . ' dan tidak dapat mengakses fitur ini.'
                ], 403);
            }

            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda berstatus ' . $user->status . ' dan belum dapat mengakses sistem.'
            ]);
        }

        return $next($request);
    }
}
