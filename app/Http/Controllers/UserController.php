<?php

namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserController
 *
 * Web/Resource Controller handling User & AlumniProfile CRUD operations
 * directly backed by the MySQL relational database.
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
        $users = User::with(['alumniProfile.department'])->latest()->get();

        if (view()->exists('users.index')) {
            $departments = Department::orderBy('name')->get();
            return view('users.index', compact('users', 'departments'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Users retrieved via UserController@index (MySQL Database Connected)',
            'total' => $users->count(),
            'data' => $users->toArray(),
        ]);
    }

    /**
     * Show the form for creating a new user (CREATE - Form view).
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();

        if (view()->exists('users.create')) {
            return view('users.create', compact('departments'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User creation form endpoint (UserController@create)',
        ]);
    }

    /**
     * Store a newly created user in database (CREATE - Action).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'student_number' => 'nullable|string|max:50',
            'graduation_year' => 'nullable|integer',
            'department_id' => 'nullable|exists:departments,id',
            'department' => 'nullable|string|max:255',
            'current_company' => 'nullable|string|max:255',
            'current_position' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'linkedin_url' => 'nullable|url|max:255',
            'bio' => 'nullable|string',
        ]);

        // 1. Create Core User
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make('password123'),
        ]);

        // 2. Resolve Department ID
        $deptId = $validated['department_id'] ?? null;
        if (!$deptId && !empty($validated['department'])) {
            $dept = Department::where('name', $validated['department'])
                ->orWhere('code', $validated['department'])
                ->first();
            $deptId = $dept?->id;
        }

        // 3. Create Associated AlumniProfile
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
            'bio' => $validated['bio'] ?? null,
            'status' => 'approved',
        ]);

        $user->load('alumniProfile.department');

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully via UserController@store in MySQL database',
                'data' => $user->toArray(),
            ], 201);
        }

        return redirect('/users')->with('success', "Mezun kullanıcı ({$user->name}) veritabanına başarıyla kaydedildi!");
    }

    /**
     * Display the specified user (READ - Single View).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        $user = User::with(['alumniProfile.department', 'experiences', 'jobPostings'])->find($id);

        if (!$user) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "User with ID {$id} not found in database",
                ], 404);
            }
            return redirect('/users')->with('error', "ID #{$id} olan kullanıcı bulunamadı.");
        }

        if (view()->exists('users.show')) {
            return view('users.show', compact('user'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User retrieved via UserController@show (MySQL Database Connected)',
            'data' => $user->toArray(),
        ]);
    }

    /**
     * Show the form for editing the specified user (UPDATE - Form view).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        $user = User::with(['alumniProfile.department'])->find($id);

        if (!$user) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "User with ID {$id} not found in database",
                ], 404);
            }
            return redirect('/users')->with('error', "ID #{$id} olan kullanıcı bulunamadı.");
        }

        $departments = Department::orderBy('name')->get();

        if (view()->exists('users.edit')) {
            return view('users.edit', compact('user', 'departments'));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User edit form endpoint (UserController@edit)',
            'data' => $user->toArray(),
        ]);
    }

    /**
     * Update the specified user in database (UPDATE - Action).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::with('alumniProfile')->find($id);

        if (!$user) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "User with ID {$id} not found in database",
                ], 404);
            }
            return redirect('/users')->with('error', "ID #{$id} olan kullanıcı bulunamadı.");
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users,email,' . $id,
            'student_number' => 'nullable|string|max:50',
            'graduation_year' => 'nullable|integer',
            'department_id' => 'nullable|exists:departments,id',
            'department' => 'nullable|string|max:255',
            'current_company' => 'nullable|string|max:255',
            'current_position' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'linkedin_url' => 'nullable|url|max:255',
            'bio' => 'nullable|string',
            'status' => 'nullable|in:pending,approved,rejected',
        ]);

        // Update core user
        $user->update([
            'name' => $validated['name'] ?? $user->name,
            'email' => $validated['email'] ?? $user->email,
        ]);

        // Resolve Department
        $deptId = $validated['department_id'] ?? $user->alumniProfile?->department_id;
        if (!empty($validated['department'])) {
            $dept = Department::where('name', $validated['department'])->first();
            if ($dept) {
                $deptId = $dept->id;
            }
        }

        // Update or create AlumniProfile
        $profileData = [
            'department_id' => $deptId,
            'student_number' => array_key_exists('student_number', $validated) ? $validated['student_number'] : $user->alumniProfile?->student_number,
            'graduation_year' => array_key_exists('graduation_year', $validated) ? $validated['graduation_year'] : $user->alumniProfile?->graduation_year,
            'current_company' => array_key_exists('current_company', $validated) ? $validated['current_company'] : $user->alumniProfile?->current_company,
            'current_position' => array_key_exists('current_position', $validated) ? $validated['current_position'] : $user->alumniProfile?->current_position,
            'city' => array_key_exists('city', $validated) ? $validated['city'] : ($user->alumniProfile?->city ?? 'İstanbul'),
            'phone' => array_key_exists('phone', $validated) ? $validated['phone'] : $user->alumniProfile?->phone,
            'linkedin_url' => array_key_exists('linkedin_url', $validated) ? $validated['linkedin_url'] : $user->alumniProfile?->linkedin_url,
            'bio' => array_key_exists('bio', $validated) ? $validated['bio'] : $user->alumniProfile?->bio,
            'status' => $validated['status'] ?? ($user->alumniProfile?->status ?? 'approved'),
        ];

        if ($user->alumniProfile) {
            $user->alumniProfile->update($profileData);
        } else {
            $user->alumniProfile()->create($profileData);
        }

        $user->load('alumniProfile.department');

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => "User with ID {$id} updated successfully in MySQL database",
                'data' => $user->toArray(),
            ]);
        }

        return redirect('/users')->with('success', "Kullanıcı #{$id} ({$user->name}) bilgileri başarıyla güncellendi!");
    }

    /**
     * Remove the specified user from database (DELETE - Action).
     *
     * @param  int|string  $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::with('alumniProfile')->find($id);

        if (!$user) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => "User with ID {$id} not found in database",
                ], 404);
            }
            return redirect('/users')->with('error', "ID #{$id} olan kullanıcı bulunamadı.");
        }

        $deletedName = $user->name;
        $user->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => "User with ID {$id} deleted successfully from MySQL database",
            ]);
        }

        return redirect('/users')->with('success', "Kullanıcı #{$id} ({$deletedName}) veritabanından başarıyla silindi!");
    }
}
