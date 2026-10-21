<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiFacultyController extends Controller
{
    /**
     * Direct Route: List all faculties (GET /api/faculties).
     */
    public function index(): JsonResponse
    {
        $faculties = Faculty::withCount('departments')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Faculties listed successfully',
            'total' => $faculties->count(),
            'data' => $faculties,
        ], 200);
    }

    /**
     * Direct Route: Show a single faculty (GET /api/faculties/{id}).
     */
    public function show($id): JsonResponse
    {
        $faculty = Faculty::with('departments')->find($id);

        if (!$faculty) {
            return response()->json([
                'status' => 'error',
                'message' => "Faculty with ID {$id} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $faculty,
        ], 200);
    }

    /**
     * Nested Route: List all departments belonging to a specific faculty (GET /api/faculties/{faculty}/departments).
     */
    public function departments($facultyId): JsonResponse
    {
        $faculty = Faculty::find($facultyId);

        if (!$faculty) {
            return response()->json([
                'status' => 'error',
                'message' => "Faculty with ID {$facultyId} not found",
            ], 404);
        }

        $departments = $faculty->departments()->withCount('alumniProfiles')->get();

        return response()->json([
            'status' => 'success',
            'faculty' => [
                'id' => $faculty->id,
                'name' => $faculty->name,
                'code' => $faculty->code,
            ],
            'total_departments' => $departments->count(),
            'data' => $departments,
        ], 200);
    }

    /**
     * Nested Route: Create a new department under a specific faculty (POST /api/faculties/{faculty}/departments).
     */
    public function storeDepartment(Request $request, $facultyId): JsonResponse
    {
        $faculty = Faculty::find($facultyId);

        if (!$faculty) {
            return response()->json([
                'status' => 'error',
                'message' => "Faculty with ID {$facultyId} not found",
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:departments,code',
        ]);

        $department = $faculty->departments()->create($validated);

        return response()->json([
            'status' => 'success',
            'message' => "Department created successfully under faculty '{$faculty->name}'",
            'data' => $department,
        ], 201);
    }
}
