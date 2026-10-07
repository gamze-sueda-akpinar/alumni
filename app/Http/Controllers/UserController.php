<?php

namespace App\Http\Controllers;

use App\Models\InMemoryUser;
use Illuminate\Http\Request;

/**
 * Class UserController
 *
 * Web/Application Controller handling User CRUD operations.
 *
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Display a listing of all users (READ - All).
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index()
    {
        $users = InMemoryUser::all();

        if (view()->exists('users.index')) {
            return view('users.index', compact('users'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Users retrieved via UserController@index',
            'total' => count($users),
            'data' => array_map(fn($u) => $u->toArray(), $users),
        ]);
    }

    /**
     * Show the form for creating a new user (CREATE - Form view).
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function create()
    {
        if (view()->exists('users.create')) {
            return view('users.create');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User creation form endpoint (UserController@create)',
        ]);
    }

    /**
     * Store a newly created user in storage (CREATE - Action).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
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

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully via UserController@store',
                'data' => $newUser->toArray(),
            ], 201);
        }

        return redirect('/users')->with('success', 'Mezun kullanıcı başarıyla kaydedildi!');
    }

    /**
     * Display the specified user (READ - Single).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function show($id)
    {
        $user = InMemoryUser::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found",
            ], 404);
        }

        if (view()->exists('users.show')) {
            return view('users.show', compact('user'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User retrieved via UserController@show',
            'data' => $user->toArray(),
        ]);
    }

    /**
     * Show the form for editing the specified user (UPDATE - Form view).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = InMemoryUser::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => "User with ID {$id} not found",
            ], 404);
        }

        if (view()->exists('users.edit')) {
            return view('users.edit', compact('user'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User edit form endpoint (UserController@edit)',
            'data' => $user->toArray(),
        ]);
    }

    /**
     * Update the specified user in storage (UPDATE - Action).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
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

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => "User with ID {$id} updated successfully via UserController@update",
                'data' => $updatedUser->toArray(),
            ]);
        }

        return redirect()->back()->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified user from storage (DELETE - Action).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
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
            'message' => "User with ID {$id} deleted successfully via UserController@destroy",
            'deleted_user' => $deletedUser->toArray(),
        ]);
    }
}
