<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthController
 *
 * Handles user onboarding, registration, login, and logout workflows.
 * Enforces the domain rule:
 * 1. Unverified users ARE PERMITTED to log in, maintain sessions, and log out.
 * 2. By default, until official verification is approved, all new accounts
 *    operate with 'student' role privileges (can view listings, apply for jobs).
 *
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * Show the registration form view.
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        $departments = Department::orderBy('name')->get();
        return view('auth.register', compact('departments'));
    }

    /**
     * Handle an incoming registration request.
     * Assigns the 'student' role by default until official verification is completed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'intended_role' => 'required|in:student,alumni,academic',
            'student_number' => 'nullable|string|max:50',
            'graduation_year' => 'nullable|integer|min:1950|max:2030',
            'department_id' => 'nullable|exists:departments,id',
            'phone' => 'nullable|string|max:50',
            'verification_document_url' => 'nullable|url|max:255',
            'terms' => 'accepted',
        ], [
            'name.required' => 'Ad ve soyad alanı zorunludur.',
            'email.required' => 'E-posta adresi zorunludur.',
            'email.email' => 'Lütfen geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi zaten sisteme kayıtlıdır.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifreniz en az 8 karakter olmalıdır.',
            'password.confirmed' => 'Şifre tekrarları birbiriyle eşleşmiyor.',
            'intended_role.required' => 'Lütfen başvurduğunuz rolü (Mezun, Öğrenci, Akademisyen) seçiniz.',
            'terms.accepted' => 'Devam etmek için kullanım şartlarını ve KVKK aydınlatma metnini onaylamalısınız.',
        ]);

        // 1. Create User: By default, role is 'student' until approved
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'student', // Default until approved!
        ]);

        // 2. Initialize Profile with 'pending' status for the intended target role
        $profile = AlumniProfile::create([
            'user_id' => $user->id,
            'department_id' => $validated['department_id'] ?? null,
            'student_number' => $validated['student_number'] ?? null,
            'graduation_year' => $validated['graduation_year'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'linkedin_url' => $validated['verification_document_url'] ?? null,
            'status' => 'pending', // Pending verification
            'bio' => 'İlk kayıt (Doğrulama Bekliyor) • Hedef rol: ' . ucfirst($validated['intended_role']),
        ]);

        // 3. Automatically authenticate user into session
        Auth::login($user);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Kaydınız başarıyla oluşturuldu ve oturum açıldı. Onaylanana kadar varsayılan rolünüz: student.',
                'user' => $user->load('alumniProfile'),
            ], 201);
        }

        return redirect('/main')->with('success', [
            'title' => 'Aramıza Hoş Geldiniz, ' . $user->name . '!',
            'role' => 'student',
            'intended_role' => $validated['intended_role'],
            'name' => $user->name,
            'email' => $user->email,
            'is_pending' => true,
            'message' => 'Hesabınız açıldı ve oturumunuz başlatıldı! Doğrulamanız onaylanana kadar sistemde varsayılan olarak "Öğrenci (Student)" haklarına sahipsiniz. İlanlara başvurabilirsiniz.',
        ]);
    }

    /**
     * Show the user login form view.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle user login authentication.
     * Explicitly allows unverified users to log in, maintain session, and access student capabilities.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'E-posta adresinizi giriniz.',
            'email.email' => 'Lütfen geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Şifrenizi giriniz.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $isPending = $user->isUnverified();

            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Giriş başarılı.',
                    'user' => $user->load('alumniProfile'),
                    'is_unverified' => $isPending,
                    'effective_role' => $user->role,
                ]);
            }

            return redirect()->intended('/main')->with('success', [
                'title' => 'Tekrar Hoş Geldiniz, ' . $user->name . '!',
                'role' => $user->role,
                'is_pending' => $isPending,
                'message' => $isPending
                    ? 'Giriş başarılı! Hesabınız henüz onaylanmadığı için onaylanana kadar varsayılan olarak "Öğrenci (Student)" yetkileriyle işlem yapabilirsiniz.'
                    : 'Giriş başarılı! Sisteme ' . strtoupper($user->role) . ' olarak bağlandınız.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Girdiğiniz e-posta adresi veya şifre kayıtlarımızla eşleşmiyor.',
        ])->onlyInput('email');
    }

    /**
     * Terminate the user session (Logout).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Oturum başarıyla kapatıldı.',
            ]);
        }

        return redirect('/main')->with('success', [
            'title' => 'Oturum Kapatıldı',
            'message' => 'Güvenli bir şekilde çıkış yaptınız. Görüşmek üzere!',
        ]);
    }
}
