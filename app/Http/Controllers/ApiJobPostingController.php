<?php

namespace App\Http\Controllers;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ApiJobPostingController
 *
 * RESTful API Controller managing JobPosting JSON endpoints and CRUD operations
 * backed directly by the MySQL relational database.
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
        $query = JobPosting::with('user');

        if ($request->filled('company')) {
            $query->where('company_name', 'like', '%' . $request->query('company') . '%');
        }

        if ($request->has('active')) {
            $query->where('is_active', $request->boolean('active'));
        }

        $jobs = $query->latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Job postings listed successfully from MySQL database',
            'total' => $jobs->count(),
            'data' => $jobs->toArray(),
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
            'application_deadline' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? (bool) $request->input('is_active') : true;
        $validated['type'] = $validated['type'] ?? 'Full-time';

        $userId = auth()->id() ?? User::value('id') ?? User::factory()->create()->id;
        $validated['user_id'] = $userId;

        $newJob = JobPosting::create($validated);
        $newJob->load('user');

        return response()->json([
            'status' => 'success',
            'message' => 'Job posting created and saved successfully in MySQL database',
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
        $job = JobPosting::with('user')->find($id);

        if (!$job) {
            return response()->json([
                'status' => 'error',
                'message' => "Job posting with ID {$id} not found in database",
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
        $job = JobPosting::find($id);

        if (!$job) {
            return response()->json([
                'status' => 'error',
                'message' => "Job posting with ID {$id} not found in database",
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'company_name' => 'sometimes|string|max:255',
            'location' => 'nullable|string|max:150',
            'type' => 'nullable|string|max:100',
            'description' => 'sometimes|string',
            'requirements' => 'nullable|string',
            'application_deadline' => 'nullable|date',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->has('is_active')) {
            $validated['is_active'] = (bool) $request->input('is_active');
        }

        $job->update($validated);
        $job->load('user');

        return response()->json([
            'status' => 'success',
            'message' => "Job posting with ID {$id} updated successfully in MySQL database",
            'data' => $job->toArray(),
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
        $job = JobPosting::find($id);

        if (!$job) {
            return response()->json([
                'status' => 'error',
                'message' => "Job posting with ID {$id} not found in database",
            ], 404);
        }

        $job->delete();

        return response()->json([
            'status' => 'success',
            'message' => "Job posting with ID {$id} deleted successfully from MySQL database",
        ], 200);
    }
}
