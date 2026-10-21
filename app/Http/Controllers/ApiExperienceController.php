<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiExperienceController extends Controller
{
    /**
     * Direct Route: Show a single experience (GET /api/experiences/{id}).
     */
    public function show($id): JsonResponse
    {
        $experience = Experience::with('user')->find($id);

        if (!$experience) {
            return response()->json([
                'status' => 'error',
                'message' => "Experience with ID {$id} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $experience,
        ], 200);
    }

    /**
     * Direct Route: Update an experience (PUT / PATCH /api/experiences/{id}).
     */
    public function update(Request $request, $id): JsonResponse
    {
        $experience = Experience::find($id);

        if (!$experience) {
            return response()->json([
                'status' => 'error',
                'message' => "Experience with ID {$id} not found",
            ], 404);
        }

        $validated = $request->validate([
            'company_name' => 'sometimes|string|max:255',
            'position' => 'sometimes|string|max:255',
            'employment_type' => 'nullable|string|max:100',
            'start_date' => 'sometimes|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $experience->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Experience updated successfully',
            'data' => $experience,
        ], 200);
    }

    /**
     * Direct Route: Delete an experience (DELETE /api/experiences/{id}).
     */
    public function destroy($id): JsonResponse
    {
        $experience = Experience::find($id);

        if (!$experience) {
            return response()->json([
                'status' => 'error',
                'message' => "Experience with ID {$id} not found",
            ], 404);
        }

        $experience->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Experience deleted successfully',
        ], 200);
    }
}
