<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class JobPostingController
 *
 * Web/Resource Controller handling JobPosting CRUD operations
 * backed directly by the MySQL relational database.
 *
 * @package App\Http\Controllers
 */
class JobPostingController extends Controller
{
    /**
     * Display a listing of job postings (READ - All).
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        $jobPostings = JobPosting::with('user')->latest()->get();

        if (view()->exists('job_postings.index')) {
            return view('job_postings.index', compact('jobPostings'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Job postings retrieved via JobPostingController@index (MySQL Database Connected)',
            'total' => $jobPostings->count(),
            'data' => $jobPostings->toArray(),
        ]);
    }

    /**
     * Show the form for creating a new job posting (CREATE - Form view).
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function create()
    {
        if (view()->exists('job_postings.create')) {
            return view('job_postings.create');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Job posting creation form endpoint (JobPostingController@create)',
        ]);
    }

    /**
     * Store a newly created job posting in database (CREATE - Action).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:150',
            'type' => 'nullable|string|max:100',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'application_deadline' => 'nullable|date',
            'contact_email' => 'nullable|email|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? (bool) $request->input('is_active') : true;
        $validated['type'] = $validated['type'] ?? 'Full-time';

        // Assign to authenticated user or first available system user
        $userId = auth()->id() ?? User::value('id') ?? User::factory()->create()->id;
        $validated['user_id'] = $userId;

        $newJob = JobPosting::create($validated);
        $newJob->load('user');

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Job posting created successfully via JobPostingController@store in MySQL database',
                'data' => $newJob->toArray(),
            ], 201);
        }

        return redirect('/job-postings')->with('success', 'İş ilanı başarıyla veritabanına kaydedildi ve listeye eklendi!');
    }

    /**
     * Display the specified job posting (READ - Single View).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $job = JobPosting::with('user')->find($id);

        if (!$job) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Job posting with ID {$id} not found in database",
                ], 404);
            }
            return redirect('/job-postings')->with('error', "ID #{$id} olan iş ilanı bulunamadı.");
        }

        if (view()->exists('job_postings.show')) {
            return view('job_postings.show', compact('job'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Job posting retrieved via JobPostingController@show (MySQL Database Connected)',
            'data' => $job->toArray(),
        ]);
    }

    /**
     * Show the form for editing the specified job posting (UPDATE - Form view).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $job = JobPosting::find($id);

        if (!$job) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Job posting with ID {$id} not found in database",
                ], 404);
            }
            return redirect('/job-postings')->with('error', "ID #{$id} olan iş ilanı bulunamadı.");
        }

        if (view()->exists('job_postings.edit')) {
            return view('job_postings.edit', compact('job'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Job posting edit form endpoint (JobPostingController@edit)',
            'data' => $job->toArray(),
        ]);
    }

    /**
     * Update the specified job posting in database (UPDATE - Action).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $job = JobPosting::find($id);

        if (!$job) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Job posting with ID {$id} not found in database",
                ], 404);
            }
            return redirect('/job-postings')->with('error', "ID #{$id} olan iş ilanı bulunamadı.");
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'company_name' => 'sometimes|string|max:255',
            'location' => 'nullable|string|max:150',
            'type' => 'nullable|string|max:100',
            'description' => 'sometimes|string',
            'requirements' => 'nullable|string',
            'application_deadline' => 'nullable|date',
            'contact_email' => 'nullable|email|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->has('is_active')) {
            $validated['is_active'] = (bool) $request->input('is_active');
        }

        $job->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => "Job posting with ID {$id} updated successfully in MySQL database",
                'data' => $job->toArray(),
            ]);
        }

        return redirect('/job-postings')->with('success', "İş ilanı #{$id} ({$job->title}) başarıyla güncellendi!");
    }

    /**
     * Remove the specified job posting from database (DELETE - Action).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $job = JobPosting::find($id);

        if (!$job) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Job posting with ID {$id} not found in database",
                ], 404);
            }
            return redirect('/job-postings')->with('error', "ID #{$id} olan iş ilanı bulunamadı.");
        }

        $deletedTitle = $job->title;
        $job->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => "Job posting with ID {$id} deleted successfully from MySQL database",
            ]);
        }

        return redirect('/job-postings')->with('success', "İş ilanı #{$id} ({$deletedTitle}) veritabanından silindi!");
    }
}
