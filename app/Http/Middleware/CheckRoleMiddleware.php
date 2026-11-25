<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CheckRoleMiddleware
 *
 * Enforces Role-Based Access Control (RBAC) across routes.
 *
 * Rules:
 * 1. Admin users have global superuser access.
 * 2. Unverified users awaiting official approval default to the 'student' role.
 *    They can access routes authorized for 'student', but are guarded against
 *    prematurely accessing 'alumni' or 'academic' restricted actions.
 *
 * @package App\Http\Middleware
 */
class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles Allowed roles (e.g. 'admin', 'alumni', 'student', 'academic')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Ensure user is authenticated
        if (!Auth::check()) {
            if ($request->is('api/*') || $request->expectsJson() || $request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'error' => 'Unauthenticated',
                    'message' => 'Lütfen bu işlem için oturum açınız.',
                    'required_roles' => $roles,
                ], 401);
            }

            return redirect()->guest(route('login'))->withErrors([
                'auth' => 'Bu sayfaya erişmek için önce giriş yapmalısınız.',
            ]);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Flatten any comma-separated string passed in route definition (e.g. 'alumni,admin')
        $allowedRoles = [];
        foreach ($roles as $roleGroup) {
            foreach (explode(',', $roleGroup) as $r) {
                $allowedRoles[] = trim(strtolower($r));
            }
        }

        // 2. Superuser bypass: Admins have access to all routes
        if ($user->isAdmin() || in_array('admin', $allowedRoles) && $user->role === 'admin') {
            return $next($request);
        }

        // 3. Resolve effective role:
        // By domain requirement: Until official verification is completed,
        // all unverified users operate with the 'student' role.
        $effectiveRole = $user->isUnverified() ? 'student' : strtolower($user->role);

        // 4. Check if effective role matches any of the allowed roles
        if (in_array($effectiveRole, $allowedRoles, true)) {
            return $next($request);
        }

        // 5. Access Denied (403 Forbidden)
        $roleLabels = [
            'admin' => 'Sistem Yöneticisi (Admin)',
            'academic' => 'Akademisyen (Academic Staff)',
            'alumni' => 'Onaylı Mezun (Alumni)',
            'student' => 'Öğrenci (Student)',
            'unverified' => 'Doğrulanmamış Kullanıcı',
        ];

        $requiredLabels = array_map(fn($r) => $roleLabels[$r] ?? ucfirst($r), $allowedRoles);
        $deniedMessage = "Bu işlem yetkiniz dışındadır. Gerekli yetki: " . implode(' veya ', $requiredLabels) . 
                         ". Mevcut statünüz: " . ($user->isUnverified() ? 'Öğrenci (Doğrulama Bekliyor)' : ucfirst($user->role)) . ".";

        if ($request->is('api/*') || $request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'status' => 'error',
                'error' => 'Forbidden',
                'message' => $deniedMessage,
                'user_role' => $user->role,
                'effective_role' => $effectiveRole,
                'required_roles' => $allowedRoles,
            ], 403);
        }

        return response()->view('errors.404', [
            'reason' => $deniedMessage,
            'referenceId' => 'AUTH-' . strtoupper(substr(md5(uniqid()), 0, 8)),
        ], 403);
    }
}
