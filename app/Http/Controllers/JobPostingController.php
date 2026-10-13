<?php

namespace App\Http\Controllers;

use App\Models\InMemoryJobPosting;
use Illuminate\Http\Request;

/**
 * Class JobPostingController
 *
 * Web/Resource Controller handling JobPosting CRUD operations.
 * Operates without a database connection using the in-memory JobPosting model.
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
        $jobPostings = InMemoryJobPosting::all();

        if (view()->exists('job_postings.index')) {
            return view('job_postings.index', compact('jobPostings'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Job postings retrieved via JobPostingController@index',
            'total' => count($jobPostings),
            'data' => array_map(fn($job) => $job->toArray(), $jobPostings),
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
     * Store a newly created job posting in storage (CREATE - Action).
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
            'application_deadline' => 'nullable|date_format:Y-m-d',
            'contact_email' => 'nullable|email|max:150',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? (bool) $request->input('is_active') : true;

        $newJob = InMemoryJobPosting::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Job posting created successfully via JobPostingController@store',
                'data' => $newJob->toArray(),
            ], 201);
        }

        return redirect('/job-postings')->with('success', 'İş ilanı başarıyla yayınlandı ve listeye eklendi!');
    }

    /**
     * Display the specified job posting (READ - Single View).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $job = InMemoryJobPosting::find($id);

        if (!$job) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Job posting with ID {$id} not found",
                ], 404);
            }
            return redirect('/job-postings')->with('error', "ID #{$id} olan iş ilanı bulunamadı.");
        }

        if (view()->exists('job_postings.show')) {
            return view('job_postings.show', compact('job'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Job posting retrieved via JobPostingController@show',
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
        $job = InMemoryJobPosting::find($id);

        if (!$job) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Job posting with ID {$id} not found",
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
     * Update the specified job posting in storage (UPDATE - Action).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'company_name' => 'sometimes|string|max:255',
            'location' => 'nullable|string|max:150',
            'type' => 'nullable|string|max:100',
            'description' => 'sometimes|string',
            'requirements' => 'nullable|string',
            'application_deadline' => 'nullable|date_format:Y-m-d',
            'contact_email' => 'nullable|email|max:150',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->has('is_active')) {
            $validated['is_active'] = (bool) $request->input('is_active');
        }

        $updatedJob = InMemoryJobPosting::update($id, $validated);

        if (!$updatedJob) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Job posting with ID {$id} not found",
                ], 404);
            }
            return redirect('/job-postings')->with('error', "ID #{$id} olan iş ilanı bulunamadı.");
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => "Job posting with ID {$id} updated successfully via JobPostingController@update",
                'data' => $updatedJob->toArray(),
            ]);
        }

        return redirect('/job-postings')->with('success', "İş ilanı #{$id} bilgileri başarıyla güncellendi!");
    }

    /**
     * Remove the specified job posting from storage (DELETE - Action).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $deletedJob = InMemoryJobPosting::delete($id);

        if (!$deletedJob) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Job posting with ID {$id} not found",
                ], 404);
            }
            return redirect('/job-postings')->with('error', "ID #{$id} olan iş ilanı bulunamadı.");
        }

        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => "Job posting with ID {$id} deleted successfully via JobPostingController@destroy",
                'deleted_job' => $deletedJob->toArray(),
            ]);
        }

        return redirect('/job-postings')->with('success', "İş ilanı #{$id} ({$deletedJob->title}) başarıyla silindi!");
    }
}
