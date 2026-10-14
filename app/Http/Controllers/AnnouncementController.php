<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

/**
 * Class AnnouncementController
 *
 * Web/Resource Controller handling Announcement CRUD operations with Blade views.
 * Interacts directly with the Eloquent Announcement model.
 *
 * @package App\Http\Controllers
 */
class AnnouncementController extends Controller
{
    /**
     * Display a listing of announcements (READ - All).
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        $announcements = Announcement::orderBy('is_pinned', 'desc')->latest()->get();

        if (view()->exists('announcements.index')) {
            return view('announcements.index', compact('announcements'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Announcements retrieved via AnnouncementController@index',
            'total' => $announcements->count(),
            'data' => $announcements->toArray(),
        ]);
    }

    /**
     * Show the form for creating a new announcement (CREATE - Form view).
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function create()
    {
        if (view()->exists('announcements.create')) {
            return view('announcements.create');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Announcement creation form endpoint (AnnouncementController@create)',
        ]);
    }

    /**
     * Store a newly created announcement in storage (CREATE - Action).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
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

        $validated['is_pinned'] = $request->has('is_pinned');
        $validated['category'] = $validated['category'] ?? 'Genel';
        $validated['author'] = $validated['author'] ?? 'Mezunlar Ofisi';
        $validated['target_audience'] = $validated['target_audience'] ?? 'Tüm Mezunlar';
        $validated['status'] = $validated['status'] ?? 'published';
        $validated['published_at'] = now();

        $newAnnouncement = Announcement::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Announcement created successfully via AnnouncementController@store',
                'data' => $newAnnouncement->toArray(),
            ], 201);
        }

        return redirect('/announcements')->with('success', 'Duyuru başarıyla yayınlandı ve listeye eklendi!');
    }

    /**
     * Display the specified announcement (READ - Single View).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Announcement with ID {$id} not found",
                ], 404);
            }
            return redirect('/announcements')->with('error', "ID #{$id} olan duyuru bulunamadı.");
        }

        if (view()->exists('announcements.show')) {
            return view('announcements.show', compact('announcement'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Announcement retrieved via AnnouncementController@show',
            'data' => $announcement->toArray(),
        ]);
    }

    /**
     * Show the form for editing the specified announcement (UPDATE - Form view).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Announcement with ID {$id} not found",
                ], 404);
            }
            return redirect('/announcements')->with('error', "ID #{$id} olan duyuru bulunamadı.");
        }

        if (view()->exists('announcements.edit')) {
            return view('announcements.edit', compact('announcement'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Announcement edit form endpoint (AnnouncementController@edit)',
            'data' => $announcement->toArray(),
        ]);
    }

    /**
     * Update the specified announcement in storage (UPDATE - Action).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Announcement with ID {$id} not found",
                ], 404);
            }
            return redirect('/announcements')->with('error', "ID #{$id} olan duyuru bulunamadı.");
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'category' => 'nullable|string|max:100',
            'author' => 'nullable|string|max:150',
            'target_audience' => 'nullable|string|max:150',
            'is_pinned' => 'nullable|boolean',
            'status' => 'nullable|string|in:published,draft,archived',
        ]);

        if ($request->has('is_pinned')) {
            $validated['is_pinned'] = (bool) $request->input('is_pinned');
        }

        $announcement->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => "Announcement with ID {$id} updated successfully via AnnouncementController@update",
                'data' => $announcement->toArray(),
            ]);
        }

        return redirect('/announcements')->with('success', "Duyuru #{$id} bilgileri başarıyla güncellendi!");
    }

    /**
     * Remove the specified announcement from storage (DELETE - Action).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $announcement = Announcement::find($id);

        if (!$announcement) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Announcement with ID {$id} not found",
                ], 404);
            }
            return redirect('/announcements')->with('error', "ID #{$id} olan duyuru bulunamadı.");
        }

        $deletedData = $announcement->toArray();
        $announcement->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => "Announcement with ID {$id} deleted successfully via AnnouncementController@destroy",
                'deleted_announcement' => $deletedData,
            ]);
        }

        return redirect('/announcements')->with('success', "Duyuru #{$id} ({$deletedData['title']}) başarıyla silindi!");
    }
}
