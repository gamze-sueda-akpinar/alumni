<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class JobApplicationController
 *
 * Web Controller managing HTML Blade interfaces for Job Applications:
 * index, create, store, show, updateStatus, and destroy.
 *
 * @package App\Http\Controllers
 */
class JobApplicationController extends Controller
{
    /**
     * Display a listing of job applications (GET /applications).
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $jobId = $request->query('job_posting_id');
        $search = $request->query('search');

        $query = JobApplication::with(['user.alumniProfile.department', 'jobPosting']);

        if ($status && in_array($status, ['pending', 'reviewed', 'shortlisted', 'accepted', 'rejected'])) {
            $query->where('status', $status);
        }

        if ($jobId) {
            $query->where('job_posting_id', $jobId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('jobPosting', function ($jq) use ($search) {
                    $jq->where('title', 'like', "%{$search}%")
                      ->orWhere('company_name', 'like', "%{$search}%");
                });
            });
        }

        $applications = $query->latest('applied_at')->get();

        // Summary metrics
        $stats = [
            'total' => JobApplication::count(),
            'pending' => JobApplication::where('status', 'pending')->count(),
            'reviewed' => JobApplication::where('status', 'reviewed')->count(),
            'shortlisted' => JobApplication::where('status', 'shortlisted')->count(),
            'accepted' => JobApplication::where('status', 'accepted')->count(),
            'rejected' => JobApplication::where('status', 'rejected')->count(),
        ];

        $jobPostings = JobPosting::select('id', 'title', 'company_name')->get();

        return view('applications.index', compact('applications', 'stats', 'jobPostings', 'status', 'jobId', 'search'));
    }

    /**
     * Show form for creating a new job application (GET /applications/create).
     */
    public function create(Request $request)
    {
        $selectedJobId = $request->query('job_posting_id');
        $jobPostings = JobPosting::where('is_active', true)->orderBy('title')->get();
        $users = User::with('alumniProfile.department')->orderBy('name')->get();

        return view('applications.create', compact('jobPostings', 'users', 'selectedJobId'));
    }

    /**
     * Store a newly created application (POST /applications).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_posting_id' => 'required|exists:job_postings,id',
            'user_id' => 'required|exists:users,id',
            'cover_letter' => 'nullable|string',
            'resume_path' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,reviewed,shortlisted,accepted,rejected',
            'notes' => 'nullable|string',
        ]);

        // Duplicate check
        $alreadyApplied = JobApplication::where('job_posting_id', $validated['job_posting_id'])
            ->where('user_id', $validated['user_id'])
            ->exists();

        if ($alreadyApplied) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Seçilen aday bu iş ilanına daha önce zaten başvuruda bulunmuştur.');
        }

        $application = JobApplication::create([
            'job_posting_id' => $validated['job_posting_id'],
            'user_id' => $validated['user_id'],
            'cover_letter' => $validated['cover_letter'] ?? null,
            'resume_path' => $validated['resume_path'] ?? null,
            'status' => $validated['status'] ?? 'pending',
            'notes' => $validated['notes'] ?? null,
            'applied_at' => now(),
        ]);

        return redirect('/applications/' . $application->id)
            ->with('success', 'İş başvurusu başarıyla oluşturuldu ve kayda alındı.');
    }

    /**
     * Display a single application details (GET /applications/{id}).
     */
    public function show($id)
    {
        $application = JobApplication::with([
            'user.alumniProfile.department.faculty',
            'user.experiences',
            'jobPosting.user'
        ])->findOrFail($id);

        return view('applications.show', compact('application'));
    }

    /**
     * Update application status and evaluation notes (POST /applications/{id}/status).
     */
    public function updateStatus(Request $request, $id)
    {
        $application = JobApplication::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,shortlisted,accepted,rejected',
            'notes' => 'nullable|string',
        ]);

        $application->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $application->notes,
        ]);

        return redirect()->back()
            ->with('success', "Başvuru durumu başarıyla '{$validated['status']}' olarak güncellendi.");
    }

    /**
     * Delete / Withdraw an application (DELETE /applications/{id}).
     */
    public function destroy($id)
    {
        $application = JobApplication::findOrFail($id);
        $application->delete();

        return redirect('/applications')
            ->with('success', 'İş başvurusu başarıyla silindi / geri çekildi.');
    }
}
