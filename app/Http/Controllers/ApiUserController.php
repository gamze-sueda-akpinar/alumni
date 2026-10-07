<?php

namespace App\Http\Controllers;

use App\Models\InMemoryUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ApiUserController
 *
 * RESTful API Controller managing User JSON endpoints and CRUD operations.
 * Operates with the database-independent InMemoryUser model.
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
        $users = InMemoryUser::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Users listed successfully',
            'total' => count($users),
            'data' => array_map(fn($u) => $u->toArray(), $users),
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
            'email' => 'required|email|max:255',
            'student_number' => 'nullable|string|max:50',
            'graduation_year' => 'nullable|integer',
            'department' => 'nullable|string|max:255',
            'current_company' => 'nullable|string|max:255',
            'current_position' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
        ]);

        $newUser = InMemoryUser::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'User created and saved successfully',
            'data' => $newUser->toArray(),
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
        $user = InMemoryUser::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found",
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
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'student_number' => 'nullable|string|max:50',
            'graduation_year' => 'nullable|integer',
            'department' => 'nullable|string|max:255',
            'current_company' => 'nullable|string|max:255',
            'current_position' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:pending,approved,rejected',
        ]);

        $updatedUser = InMemoryUser::update($id, $validated);

        if (!$updatedUser) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => "User with ID {$id} updated successfully",
            'data' => $updatedUser->toArray(),
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
        $deletedUser = InMemoryUser::delete($id);

        if (!$deletedUser) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => "User with ID {$id} deleted successfully",
            'deleted_user' => $deletedUser->toArray(),
        ], 200);
    }
}
