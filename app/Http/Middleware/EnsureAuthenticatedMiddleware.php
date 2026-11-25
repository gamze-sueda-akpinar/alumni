<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EnsureAuthenticatedMiddleware
 *
 * Enforces authentication for protected endpoints while explicitly permitting
 * unverified accounts to access the application with student baseline capabilities.
 *
 * @package App\Http\Middleware
 */
class EnsureAuthenticatedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->is('api/*') || $request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Unauthenticated',
                    'message' => 'Bu işlem için oturum açmanız gerekmektedir.',
                    'login_url' => route('login'),
                ], 401);
            }

            // Save intended URL and redirect to login
            return redirect()->guest(route('login'))->withErrors([
                'auth' => 'Bu sayfaya veya işleme erişmek için lütfen önce giriş yapınız.',
            ]);
        }

        return $next($request);
    }
}
