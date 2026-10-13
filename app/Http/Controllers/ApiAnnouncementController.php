<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ApiAnnouncementController
 *
 * RESTful API Controller managing Announcement JSON endpoints and CRUD operations.
 * Operates with the database-independent Announcement model.
 *
 * @package App\Http\Controllers
 */
class ApiAnnouncementController extends Controller
{
    /**
     * Display a listing of all announcements (GET /api/announcements).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->has('category')) {
            $announcements = Announcement::byCategory($request->query('category'));
        } elseif ($request->boolean('pinned')) {
            $announcements = Announcement::pinned();
        } else {
            $announcements = Announcement::all();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Announcements listed successfully',
            'total' => count($announcements),
            'data' => array_map(fn($a) => $a->toArray(), $announcements),
        ], 200);
    }

    /**
     * Store a newly created announcement (POST /api/announcements).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'author' => 'nullable|string|max:150',
            'target_audience' => 'nullable|string|max:150',
            'is_pinned' => 'nullable|boolean',
            'status' => 'nullable|string|in:published,draft,archived',
        ]);

        $newAnnouncement = Announcement::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Announcement created and saved successfully',
            'data' => $newAnnouncement->toArray(),
        ], 201);
    }

    /**
     * Display the specified announcement (GET /api/announcements/{id}).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            return response()->json([
                'status' => 'error',
                'message' => "Announcement with ID {$id} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $announcement->toArray(),
        ], 200);
    }

    /**
     * Update the specified announcement (PUT / PATCH /api/announcements/{id}).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'category' => 'nullable|string|max:100',
            'author' => 'nullable|string|max:150',
            'target_audience' => 'nullable|string|max:150',
            'is_pinned' => 'nullable|boolean',
            'status' => 'nullable|string|in:published,draft,archived',
        ]);

        $updatedAnnouncement = Announcement::update($id, $validated);

        if (!$updatedAnnouncement) {
            return response()->json([
                'status' => 'error',
                'message' => "Announcement with ID {$id} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Announcement with ID {$id} updated successfully",
            'data' => $updatedAnnouncement->toArray(),
        ], 200);
    }

    /**
     * Remove the specified announcement (DELETE /api/announcements/{id}).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $deletedAnnouncement = Announcement::delete($id);

        if (!$deletedAnnouncement) {
            return response()->json([
                'status' => 'error',
                'message' => "Announcement with ID {$id} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Announcement with ID {$id} deleted successfully",
            'deleted_announcement' => $deletedAnnouncement->toArray(),
        ], 200);
    }
}
