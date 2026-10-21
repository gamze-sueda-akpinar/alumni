<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiDepartmentController extends Controller
{
    /**
     * Direct Route: List all departments (GET /api/departments).
     */
    public function index(): JsonResponse
    {
        $departments = Department::with('faculty')->withCount('alumniProfiles')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Departments listed successfully',
            'total' => $departments->count(),
            'data' => $departments,
        ], 200);
    }

    /**
     * Direct Route: Show a single department (GET /api/departments/{id}).
     */
    public function show($id): JsonResponse
    {
        $department = Department::with('faculty')->withCount('alumniProfiles')->find($id);

        if (!$department) {
            return response()->json([
                'status' => 'error',
                'message' => "Department with ID {$id} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $department,
        ], 200);
    }

    /**
     * Nested Route: List all alumni profiles graduated from this department (GET /api/departments/{department}/alumni).
     */
    public function alumni($departmentId): JsonResponse
    {
        $department = Department::with('faculty')->find($departmentId);

        if (!$department) {
            return response()->json([
                'status' => 'error',
                'message' => "Department with ID {$departmentId} not found",
            ], 404);
        }

        $alumni = $department->alumniProfiles()->with('user')->approved()->get();

        return response()->json([
            'status' => 'success',
            'department' => [
                'id' => $department->id,
                'name' => $department->name,
                'code' => $department->code,
                'faculty' => $department->faculty?->name,
            ],
            'total_alumni' => $alumni->count(),
            'data' => $alumni,
        ], 200);
    }
}
