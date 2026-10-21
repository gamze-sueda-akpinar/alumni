<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobPosting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiJobApplicationController extends Controller
{
    /**
     * Direct Route: List all applications (GET /api/applications).
     * Supports optional query filtering: ?status=..., ?job_posting_id=..., ?user_id=...
     */
    public function index(Request $request): JsonResponse
    {
        $query = JobApplication::with(['user.alumniProfile', 'jobPosting']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('job_posting_id')) {
            $query->where('job_posting_id', $request->input('job_posting_id'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        $applications = $query->latest('applied_at')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Job applications retrieved successfully',
            'total' => $applications->count(),
            'data' => $applications,
        ], 200);
    }

    /**
     * Direct Route: Store a new job application (POST /api/applications).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'job_posting_id' => 'required|exists:job_postings,id',
            'user_id' => 'required|exists:users,id',
            'cover_letter' => 'nullable|string',
            'resume_path' => 'nullable|string|max:255',
            'status' => 'nullable|in:pending,reviewed,shortlisted,accepted,rejected',
            'notes' => 'nullable|string',
        ]);

        // Check if user already applied to this job posting
        $exists = JobApplication::where('job_posting_id', $validated['job_posting_id'])
            ->where('user_id', $validated['user_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'User has already submitted an application for this job posting',
            ], 422);
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

        $application->load(['user.alumniProfile', 'jobPosting']);

        return response()->json([
            'status' => 'success',
            'message' => 'Job application submitted successfully',
            'data' => $application,
        ], 201);
    }

    /**
     * Direct Route: Show a single application (GET /api/applications/{id}).
     */
    public function show($id): JsonResponse
    {
        $application = JobApplication::with(['user.alumniProfile.department', 'jobPosting'])->find($id);

        if (!$application) {
            return response()->json([
                'status' => 'error',
                'message' => "Job application with ID {$id} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $application,
        ], 200);
    }

    /**
     * Direct Route: Update an application (PUT / PATCH /api/applications/{id}).
     */
    public function update(Request $request, $id): JsonResponse
    {
        $application = JobApplication::find($id);

        if (!$application) {
            return response()->json([
                'status' => 'error',
                'message' => "Job application with ID {$id} not found",
            ], 404);
        }

        $validated = $request->validate([
            'status' => 'sometimes|in:pending,reviewed,shortlisted,accepted,rejected',
            'notes' => 'nullable|string',
            'cover_letter' => 'nullable|string',
            'resume_path' => 'nullable|string|max:255',
        ]);

        $application->update($validated);
        $application->load(['user.alumniProfile', 'jobPosting']);

        return response()->json([
            'status' => 'success',
            'message' => 'Job application updated successfully',
            'data' => $application,
        ], 200);
    }

    /**
     * Direct Route: Delete or withdraw an application (DELETE /api/applications/{id}).
     */
    public function destroy($id): JsonResponse
    {
        $application = JobApplication::find($id);

        if (!$application) {
            return response()->json([
                'status' => 'error',
                'message' => "Job application with ID {$id} not found",
            ], 404);
        }

        $application->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Job application deleted/withdrawn successfully',
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | Nested Routes for Job Postings (/api/job-postings/{id}/applications)
    |--------------------------------------------------------------------------
    */

    /**
     * Nested Route: List all applications for a specific job posting (GET /api/job-postings/{id}/applications).
     */
    public function forJobPosting($jobPostingId): JsonResponse
    {
        $jobPosting = JobPosting::find($jobPostingId);

        if (!$jobPosting) {
            return response()->json([
                'status' => 'error',
                'message' => "Job posting with ID {$jobPostingId} not found",
            ], 404);
        }

        $applications = $jobPosting->applications()->with('user.alumniProfile')->latest('applied_at')->get();

        return response()->json([
            'status' => 'success',
            'job_posting' => [
                'id' => $jobPosting->id,
                'title' => $jobPosting->title,
                'company_name' => $jobPosting->company_name,
                'type' => $jobPosting->type,
            ],
            'total_applications' => $applications->count(),
            'data' => $applications,
        ], 200);
    }

    /**
     * Nested Route: Submit application directly for a job posting (POST /api/job-postings/{id}/applications).
     */
    public function storeForJobPosting(Request $request, $jobPostingId): JsonResponse
    {
        $jobPosting = JobPosting::find($jobPostingId);

        if (!$jobPosting) {
            return response()->json([
                'status' => 'error',
                'message' => "Job posting with ID {$jobPostingId} not found",
            ], 404);
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'cover_letter' => 'nullable|string',
            'resume_path' => 'nullable|string|max:255',
        ]);

        $exists = JobApplication::where('job_posting_id', $jobPostingId)
            ->where('user_id', $validated['user_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'User has already applied to this job posting',
            ], 422);
        }

        $application = $jobPosting->applications()->create([
            'user_id' => $validated['user_id'],
            'cover_letter' => $validated['cover_letter'] ?? null,
            'resume_path' => $validated['resume_path'] ?? null,
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        $application->load('user.alumniProfile');

        return response()->json([
            'status' => 'success',
            'message' => "Application submitted successfully for '{$jobPosting->title}'",
            'data' => $application,
        ], 201);
    }
}
