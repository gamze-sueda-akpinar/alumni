<?php

namespace App\Http\Controllers;

use App\Models\InMemoryJobPosting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ApiJobPostingController
 *
 * RESTful API Controller managing JobPosting JSON endpoints and CRUD operations.
 * Operates without a database connection using the in-memory JobPosting model.
 *
 * @package App\Http\Controllers
 */
class ApiJobPostingController extends Controller
{
    /**
     * Display a listing of all job postings (GET /api/job-postings).
     * Supports filtering by ?company=... or ?active=1
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->filled('company')) {
            $jobs = InMemoryJobPosting::byCompany($request->query('company'));
        } elseif ($request->has('active')) {
            $jobs = $request->boolean('active')
                ? InMemoryJobPosting::active()
                : InMemoryJobPosting::all();
        } else {
            $jobs = InMemoryJobPosting::all();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Job postings listed successfully',
            'total' => count($jobs),
            'data' => array_map(fn($job) => $job->toArray(), $jobs),
        ], 200);
    }

    /**
     * Store a newly created job posting (POST /api/job-postings).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
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

        $newJob = InMemoryJobPosting::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Job posting created and saved successfully',
            'data' => $newJob->toArray(),
        ], 201);
    }

    /**
     * Display the specified job posting (GET /api/job-postings/{id}).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $job = InMemoryJobPosting::find($id);

        if (!$job) {
            return response()->json([
                'status' => 'error',
                'message' => "Job posting with ID {$id} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $job->toArray(),
        ], 200);
    }

    /**
     * Update the specified job posting (PUT / PATCH /api/job-postings/{id}).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
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

        $updatedJob = InMemoryJobPosting::update($id, $validated);

        if (!$updatedJob) {
            return response()->json([
                'status' => 'error',
                'message' => "Job posting with ID {$id} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Job posting with ID {$id} updated successfully",
            'data' => $updatedJob->toArray(),
        ], 200);
    }

    /**
     * Remove the specified job posting (DELETE /api/job-postings/{id}).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $deletedJob = InMemoryJobPosting::delete($id);

        if (!$deletedJob) {
            return response()->json([
                'status' => 'error',
                'message' => "Job posting with ID {$id} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Job posting with ID {$id} deleted successfully",
            'deleted_job' => $deletedJob->toArray(),
        ], 200);
    }
}
