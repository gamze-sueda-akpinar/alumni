<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class ApiUserController
 *
 * RESTful API Controller managing User JSON endpoints and CRUD operations
 * backed directly by the MySQL relational database.
 *
 * @package App\Http\Controllers
 */
class ApiUserController extends Controller
{
    /**
     * Display a listing of all users (GET /api/users).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::with(['alumniProfile.department', 'experiences'])->latest()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Users listed successfully from MySQL database',
            'total' => $users->count(),
            'data' => $users->toArray(),
        ], 200);
    }

    /**
     * Store a newly created user (POST /api/users).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:6',
            'student_number' => 'nullable|string|max:50',
            'graduation_year' => 'nullable|integer',
            'department_id' => 'nullable|exists:departments,id',
            'department' => 'nullable|string|max:255',
            'current_company' => 'nullable|string|max:255',
            'current_position' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'bio' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password'] ?? 'password123'),
        ]);

        $deptId = $validated['department_id'] ?? null;
        if (!$deptId && !empty($validated['department'])) {
            $dept = Department::where('name', $validated['department'])->orWhere('code', $validated['department'])->first();
            $deptId = $dept?->id;
        }

        $user->alumniProfile()->create([
            'department_id' => $deptId,
            'student_number' => $validated['student_number'] ?? null,
            'graduation_year' => $validated['graduation_year'] ?? null,
            'current_company' => $validated['current_company'] ?? null,
            'current_position' => $validated['current_position'] ?? null,
            'city' => $validated['city'] ?? 'İstanbul',
            'country' => 'Türkiye',
            'phone' => $validated['phone'] ?? null,
            'linkedin_url' => $validated['linkedin_url'] ?? null,
            'github_url' => $validated['github_url'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'status' => 'approved',
        ]);

        $user->load('alumniProfile.department');

        return response()->json([
            'status' => 'success',
            'message' => 'User created and saved successfully in MySQL database',
            'data' => $user->toArray(),
        ], 201);
    }

    /**
     * Display the specified user (GET /api/users/{id}).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $user = User::with(['alumniProfile.department', 'experiences', 'jobPostings'])->find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found in database",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user->toArray(),
        ], 200);
    }

    /**
     * Update the specified user (PUT / PATCH /api/users/{id}).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $user = User::with('alumniProfile')->find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found in database",
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $id,
            'student_number' => 'nullable|string|max:50',
            'graduation_year' => 'nullable|integer',
            'department_id' => 'nullable|exists:departments,id',
            'current_company' => 'nullable|string|max:255',
            'current_position' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'linkedin_url' => 'nullable|url|max:255',
            'bio' => 'nullable|string',
            'status' => 'nullable|in:pending,approved,rejected',
        ]);

        $user->update([
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'] ?? $user->email,
        ]);

        $profileData = array_filter([
            'department_id' => $validated['department_id'] ?? $user->alumniProfile?->department_id,
            'student_number' => $validated['student_number'] ?? $user->alumniProfile?->student_number,
            'graduation_year' => $validated['graduation_year'] ?? $user->alumniProfile?->graduation_year,
            'current_company' => $validated['current_company'] ?? $user->alumniProfile?->current_company,
            'current_position' => $validated['current_position'] ?? $user->alumniProfile?->current_position,
            'city' => $validated['city'] ?? $user->alumniProfile?->city,
            'phone' => $validated['phone'] ?? $user->alumniProfile?->phone,
            'linkedin_url' => $validated['linkedin_url'] ?? $user->alumniProfile?->linkedin_url,
            'bio' => $validated['bio'] ?? $user->alumniProfile?->bio,
            'status' => $validated['status'] ?? $user->alumniProfile?->status,
        ], fn($val) => !is_null($val));

        if ($user->alumniProfile) {
            $user->alumniProfile->update($profileData);
        } else {
            $user->alumniProfile()->create($profileData);
        }

        $user->load('alumniProfile.department');

        return response()->json([
            'status' => 'success',
            'message' => "User with ID {$id} updated successfully in MySQL database",
            'data' => $user->toArray(),
        ], 200);
    }

    /**
     * Remove the specified user (DELETE /api/users/{id}).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found in database",
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => "User with ID {$id} deleted successfully from MySQL database",
        ], 200);
    }

    /*
    |--------------------------------------------------------------------------
    | Nested Resource Endpoints (/api/users/{user}/...)
    |--------------------------------------------------------------------------
    */

    /**
     * Nested Route: Get alumni profile of a specific user (GET /api/users/{user}/profile).
     */
    public function profile($id): JsonResponse
    {
        $user = User::with('alumniProfile.department.faculty')->find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found",
            ], 404);
        }

        if (!$user->alumniProfile) {
            return response()->json([
                'status' => 'error',
                'message' => "Alumni profile not found for user {$id}",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'profile' => $user->alumniProfile,
        ], 200);
    }

    /**
     * Nested Route: Update alumni profile of a specific user (PUT / PATCH /api/users/{user}/profile).
     */
    public function updateProfile(Request $request, $id): JsonResponse
    {
        $user = User::with('alumniProfile')->find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found",
            ], 404);
        }

        $validated = $request->validate([
            'department_id' => 'nullable|exists:departments,id',
            'student_number' => 'nullable|string|max:50',
            'graduation_year' => 'nullable|integer',
            'current_company' => 'nullable|string|max:255',
            'current_position' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'bio' => 'nullable|string',
            'status' => 'nullable|in:pending,approved,rejected',
        ]);

        if ($user->alumniProfile) {
            $user->alumniProfile->update($validated);
        } else {
            $user->alumniProfile()->create($validated);
        }

        $user->load('alumniProfile.department');

        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => $user->alumniProfile,
        ], 200);
    }

    /**
     * Nested Route: List all experiences of a specific user (GET /api/users/{user}/experiences).
     */
    public function experiences($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found",
            ], 404);
        }

        $experiences = $user->experiences()->latest('start_date')->get();

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ],
            'total_experiences' => $experiences->count(),
            'data' => $experiences,
        ], 200);
    }

    /**
     * Nested Route: Create a new experience for a specific user (POST /api/users/{user}/experiences).
     */
    public function storeExperience(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found",
            ], 404);
        }

        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'employment_type' => 'nullable|string|max:100',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $experience = $user->experiences()->create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Experience created successfully for user',
            'data' => $experience,
        ], 201);
    }

    /**
     * Nested Route: List all job postings published by a specific user (GET /api/users/{user}/job-postings).
     */
    public function jobPostings($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found",
            ], 404);
        }

        $jobPostings = $user->jobPostings()->latest()->get();

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ],
            'total_job_postings' => $jobPostings->count(),
            'data' => $jobPostings,
        ], 200);
    }

    /**
     * Nested Route: Create a job posting authored by a specific user (POST /api/users/{user}/job-postings).
     */
    public function storeJobPosting(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found",
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:100',
            'description' => 'required|string',
            'requirements' => 'nullable|string',
            'application_deadline' => 'nullable|date',
            'contact_email' => 'nullable|email|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $job = $user->jobPostings()->create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Job posting authored and created successfully',
            'data' => $job,
        ], 201);
    }

    /**
     * Nested Route: List all job applications submitted by a specific user (GET /api/users/{user}/applications).
     */
    public function applications($id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found",
            ], 404);
        }

        $applications = $user->applications()->with('jobPosting')->latest('applied_at')->get();

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
            ],
            'total_applications' => $applications->count(),
            'data' => $applications,
        ], 200);
    }

    /**
     * Nested Route: Submit a job application on behalf of a specific user (POST /api/users/{user}/applications).
     */
    public function storeApplication(Request $request, $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found",
            ], 404);
        }

        $validated = $request->validate([
            'job_posting_id' => 'required|exists:job_postings,id',
            'cover_letter' => 'nullable|string',
            'resume_path' => 'nullable|string|max:255',
        ]);

        $exists = $user->applications()->where('job_posting_id', $validated['job_posting_id'])->exists();

        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'User has already submitted an application for this job posting',
            ], 422);
        }

        $application = $user->applications()->create([
            'job_posting_id' => $validated['job_posting_id'],
            'cover_letter' => $validated['cover_letter'] ?? null,
            'resume_path' => $validated['resume_path'] ?? null,
            'status' => 'pending',
            'applied_at' => now(),
        ]);

        $application->load('jobPosting');

        return response()->json([
            'status' => 'success',
            'message' => 'Job application submitted successfully',
            'data' => $application,
        ], 201);
    }
}
