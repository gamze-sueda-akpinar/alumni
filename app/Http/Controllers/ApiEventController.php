<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiEventController extends Controller
{
    /**
     * Direct Route: List all events (GET /api/events).
     */
    public function index(): JsonResponse
    {
        $events = Event::latest('event_date')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Events listed successfully',
            'total' => $events->count(),
            'data' => $events,
        ], 200);
    }

    /**
     * Direct Route: Store a newly created event (POST /api/events).
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'is_online' => 'nullable|boolean',
            'meeting_link' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $event = Event::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Event created successfully',
            'data' => $event,
        ], 201);
    }

    /**
     * Direct Route: Show a single event (GET /api/events/{id}).
     */
    public function show($id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'status' => 'error',
                'message' => "Event with ID {$id} not found",
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $event,
        ], 200);
    }

    /**
     * Direct Route: Update an event (PUT / PATCH /api/events/{id}).
     */
    public function update(Request $request, $id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'status' => 'error',
                'message' => "Event with ID {$id} not found",
            ], 404);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'event_date' => 'sometimes|date',
            'location' => 'nullable|string|max:255',
            'is_online' => 'nullable|boolean',
            'meeting_link' => 'nullable|url|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $event->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Event updated successfully',
            'data' => $event,
        ], 200);
    }

    /**
     * Direct Route: Delete an event (DELETE /api/events/{id}).
     */
    public function destroy($id): JsonResponse
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'status' => 'error',
                'message' => "Event with ID {$id} not found",
            ], 404);
        }

        $event->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Event deleted successfully',
        ], 200);
    }
}
