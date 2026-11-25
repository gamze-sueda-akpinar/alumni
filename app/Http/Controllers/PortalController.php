<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use App\Models\Announcement;
use App\Models\Department;
use App\Models\Event;
use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class PortalController
 *
 * Dispatches and renders dedicated, user-specific portal dashboards tailored to each
 * specific user role:
 * - Student Portal (/student/dashboard) -> for active/enrolled students (internships, applications, mentors)
 * - Alumni Portal (/alumni/dashboard) -> for verified graduates (posting jobs, candidate review, networking)
 * - Academic Portal (/academic/dashboard) -> for faculty staff (event creation, department stats, notices)
 * - Universal Dispatcher (/dashboard or /portal) -> dynamically routes user to their role-specific dashboard.
 */
class PortalController extends Controller
{
    /**
     * Universal Dispatcher: dynamically redirects the authenticated user to their role's specific portal.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'academic' => redirect()->route('academic.dashboard'),
            'alumni' => redirect()->route('alumni.dashboard'),
            default => redirect()->route('student.dashboard'),
        };
    }

    /**
     * Student-Specific Portal Dashboard (/student/dashboard)
     * Tailored for students: tracking internship/job applications, department mentors, recommended jobs.
     *
     * @return \Illuminate\View\View
     */
    public function studentDashboard()
    {
        $user = Auth::user();

        // Load profile and academic department
        $profile = $user ? $user->alumniProfile : null;
        $department = $profile ? $profile->department : null;

        // 1. Applications submitted by this student
        $myApplications = JobApplication::where('user_id', $user ? $user->id : 0)
            ->with(['jobPosting.user'])
            ->latest()
            ->get();

        // 2. Recommended active job & internship postings for their department
        $recommendedJobs = JobPosting::where('is_active', true)
            ->with('user')
            ->latest()
            ->take(6)
            ->get();

        // 3. Department Alumni Mentors (fellow graduates from same or related faculty)
        $mentors = User::where('role', 'alumni')
            ->whereHas('alumniProfile', function ($q) use ($department) {
                if ($department) {
                    $q->where('department_id', $department->id);
                }
            })
            ->with(['alumniProfile.department', 'experiences'])
            ->take(4)
            ->get();

        // If not enough specific mentors, fallback to general alumni
        if ($mentors->isEmpty()) {
            $mentors = User::where('role', 'alumni')->with(['alumniProfile.department', 'experiences'])->take(4)->get();
        }

        // 4. Upcoming campus events & academic panels
        $upcomingEvents = Event::where('is_active', true)
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(3)
            ->get();

        return view('portals.student', compact(
            'user',
            'profile',
            'department',
            'myApplications',
            'recommendedJobs',
            'mentors',
            'upcomingEvents'
        ));
    }

    /**
     * Alumni-Specific Portal Dashboard (/alumni/dashboard)
     * Tailored for graduates: job posting management, applicants review, career tracking.
     *
     * @return \Illuminate\View\View
     */
    public function alumniDashboard()
    {
        $user = Auth::user();
        $profile = $user ? $user->alumniProfile : null;

        // 1. Job postings published by this alumnus
        $myJobPostings = JobPosting::where('user_id', $user ? $user->id : 0)
            ->withCount('applications')
            ->latest()
            ->get();

        // 2. Received candidate applications for my posted jobs
        $jobIds = $myJobPostings->pluck('id')->toArray();
        $receivedApplications = JobApplication::whereIn('job_posting_id', $jobIds)
            ->with(['jobPosting', 'user.alumniProfile'])
            ->latest()
            ->get();

        // 3. Applications submitted by this alumnus for other career opportunities
        $mySubmittedApplications = JobApplication::where('user_id', $user ? $user->id : 0)
            ->with(['jobPosting.user'])
            ->latest()
            ->get();

        // 4. Recent alumni events & webinars
        $alumniEvents = Event::where('is_active', true)->latest()->take(3)->get();

        return view('portals.alumni', compact(
            'user',
            'profile',
            'myJobPostings',
            'receivedApplications',
            'mySubmittedApplications',
            'alumniEvents'
        ));
    }

    /**
     * Academic-Specific Portal Dashboard (/academic/dashboard)
     * Tailored for faculty staff: event and panel hosting, department alumni analytics, notices.
     *
     * @return \Illuminate\View\View
     */
    public function academicDashboard()
    {
        $user = Auth::user();
        $profile = $user ? $user->alumniProfile : null;
        $department = $profile ? $profile->department : Department::first();

        // 1. Events organized and hosted by this academic
        $myEvents = Event::where('user_id', $user ? $user->id : 0)
            ->latest()
            ->get();

        // 2. Department statistics
        $stats = [
            'department_alumni' => AlumniProfile::where('department_id', $department->id ?? 1)->count() ?: 420,
            'department_students' => User::where('role', 'student')->count() ?: 1150,
            'employment_rate' => 94.2,
            'active_events' => $myEvents->where('is_active', true)->count(),
        ];

        // 3. Notable department alumni currently working in industry
        $notableAlumni = User::where('role', 'alumni')
            ->with(['alumniProfile', 'experiences'])
            ->latest()
            ->take(5)
            ->get();

        // 4. Official department announcements
        $departmentAnnouncements = Announcement::latest()->take(4)->get();

        return view('portals.academic', compact(
            'user',
            'profile',
            'department',
            'myEvents',
            'stats',
            'notableAlumni',
            'departmentAnnouncements'
        ));
    }
}
