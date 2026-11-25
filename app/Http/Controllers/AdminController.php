<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class AdminController
 *
 * Provides comprehensive institutional management and data manipulation capabilities
 * for the Alumni Tracking System.
 * Accessible exclusively by system administrators (e.g. Antigravity Super Admin).
 *
 * @package App\Http\Controllers
 */
class AdminController extends Controller
{
    /**
     * Display the Admin Control Panel dashboard with full system metrics and data tables.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Calculate live system metrics
        $stats = [
            'total_users' => User::count(),
            'pending_verifications' => AlumniProfile::where('status', 'pending')->count(),
            'approved_alumni' => User::where('role', 'alumni')->count(),
            'active_students' => User::where('role', 'student')->count(),
            'academics' => User::where('role', 'academic')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'total_jobs' => JobPosting::count(),
            'active_jobs' => JobPosting::where('is_active', true)->count(),
            'total_applications' => JobApplication::count(),
            'total_events' => Event::count(),
            'total_announcements' => Announcement::count(),
        ];

        // 2. Fetch pending verification queue
        $pendingUsers = User::whereHas('alumniProfile', function ($q) {
            $q->where('status', 'pending');
        })->orWhere('role', 'unverified')->with(['alumniProfile.department'])->latest()->get();

        // 3. Fetch all system users
        $users = User::with(['alumniProfile.department'])->latest()->take(50)->get();

        // 4. Fetch job postings
        $jobPostings = JobPosting::with('user')->latest()->take(30)->get();

        // 5. Fetch job applications
        $applications = JobApplication::with(['jobPosting', 'user'])->latest()->take(30)->get();

        // 6. Fetch events
        $events = Event::latest()->take(20)->get();

        return view('admin.dashboard', compact(
            'stats',
            'pendingUsers',
            'users',
            'jobPostings',
            'applications',
            'events'
        ));
    }

    /**
     * Approve an unverified user's credential verification and promote them to their intended role.
     *
     * @param  int  $id User ID
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function approveUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Resolve target role from profile or request (students with future graduation year like 2027 are supported)
        $targetRole = $request->input('role');
        if (!$targetRole) {
            $gradYear = $user->alumniProfile->graduation_year ?? null;
            if ($user->alumniProfile && str_contains(strtolower($user->alumniProfile->bio ?? ''), 'academic')) {
                $targetRole = 'academic';
            } elseif ($gradYear && $gradYear > 2026) {
                // Future graduation year indicates an active student (e.g. 2027)
                $targetRole = 'student';
            } elseif ($gradYear) {
                $targetRole = 'alumni';
            } else {
                $targetRole = 'student';
            }
        }

        $user->role = $targetRole;
        $user->save();

        if ($user->alumniProfile) {
            $user->alumniProfile->status = 'approved';
            $user->alumniProfile->save();
        }

        $roleLabel = match($targetRole) {
            'student' => 'Öğrenci (Aktif Öğrenci)',
            'alumni' => 'Mezun (Alumni)',
            'academic' => 'Akademisyen',
            'admin' => 'Yönetici',
            default => strtoupper($targetRole),
        };

        $msg = "{$user->name} kullanıcısının doğrulaması onaylandı ve rolü '{$roleLabel}' olarak aktif edildi.";

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => $msg,
                'user' => $user->load('alumniProfile'),
            ]);
        }

        return back()->with('admin_success', $msg);
    }

    /**
     * Reject a pending verification request.
     *
     * @param  int  $id User ID
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function rejectUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        if ($user->alumniProfile) {
            $user->alumniProfile->status = 'rejected';
            $user->alumniProfile->save();
        }

        $msg = "{$user->name} kullanıcısının doğrulama başvurusu reddedildi.";

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => $msg,
            ]);
        }

        return back()->with('admin_warning', $msg);
    }

    /**
     * Update a user's system authorization role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function updateUserRole(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,academic,alumni,student,unverified',
        ]);

        $user = User::findOrFail($id);
        $oldRole = $user->role;
        $user->role = $validated['role'];
        $user->save();

        $msg = "{$user->name} kullanıcısının rolü '{$oldRole}' durumundan '{$user->role}' olarak güncellendi.";

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => $msg, 'user' => $user]);
        }

        return back()->with('admin_success', $msg);
    }

    /**
     * Toggle a job posting's active publication state.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function toggleJobPosting(Request $request, $id)
    {
        $job = JobPosting::findOrFail($id);
        $job->is_active = !$job->is_active;
        $job->save();

        $statusText = $job->is_active ? 'Yayına Alındı (Aktif)' : 'Yayından Kaldırıldı (Pasif)';
        $msg = "'{$job->title}' ilanı {$statusText}.";

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => $msg, 'job' => $job]);
        }

        return back()->with('admin_success', $msg);
    }

    /**
     * Update an application's evaluation status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function updateApplicationStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,accepted,rejected',
        ]);

        $app = JobApplication::findOrFail($id);
        $app->status = $validated['status'];
        $app->save();

        $msg = "Başvuru (#{$app->id}) durumu '{$app->status}' olarak güncellendi.";

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => $msg, 'application' => $app]);
        }

        return back()->with('admin_success', $msg);
    }

    /**
     * Delete a job posting from the system.
     */
    public function deleteJobPosting(Request $request, $id)
    {
        $job = JobPosting::findOrFail($id);
        $title = $job->title;
        $job->delete();

        $msg = "'{$title}' ilanı sistemden silindi.";

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => $msg]);
        }

        return back()->with('admin_success', $msg);
    }

    /**
     * Delete a user account from the system.
     */
    public function deleteUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $name = $user->name;
        $user->delete();

        $msg = "'{$name}' kullanıcısı ve ilişkili tüm kayıtları sistemden silindi.";

        if ($request->wantsJson()) {
            return response()->json(['status' => 'success', 'message' => $msg]);
        }

        return back()->with('admin_success', $msg);
    }
}
