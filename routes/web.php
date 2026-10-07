<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'ok';
});

Route::get('/hello', function () {
    return 'Hello, World!';
});

Route::get('/hello/{name}', function (string $name) {
    return 'Hello, ' . ucfirst($name) . '!';
});

Route::get('/sum/{number1}/{number2}', function ($number1, $number2) {
    return (string) ($number1 + $number2);
});

Route::get('/main', function () {
    return view('main');
});

Route::get('/home', function () {
    return view('main');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/api/health', function () {
    try {
        DB::connection()->getPdo();
        $dbStatus = 'connected';
    } catch (\Exception $e) {
        $dbStatus = 'disconnected';
    }

    return response()->json([
        'status' => 'ok',
        'message' => 'Alumni Tracking System API is healthy',
        'timestamp' => now()->toIso8601String(),
        'database' => $dbStatus,
    ]);
});

// POST /api/users - Yeni kullanıcı oluşturma (Model aracılığıyla)
Route::post('/api/users', function (\Illuminate\Http\Request $request) {
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

    $newUser = \App\Models\InMemoryUser::create($validated);

    return response()->json([
        'status' => 'success',
        'message' => 'User created and saved successfully',
        'data' => $newUser->toArray(),
    ], 201);
});

// GET /api/users - Kullanıcıları listeleme (Model aracılığıyla)
Route::get('/api/users', function () {
    $users = \App\Models\InMemoryUser::all();

    return response()->json([
        'status' => 'success',
        'message' => 'Users listed successfully',
        'total' => count($users),
        'data' => array_map(fn($u) => $u->toArray(), $users),
    ], 200);
});

// GET /api/users/{id} - Tekil kullanıcı getirme (Model aracılığıyla)
Route::get('/api/users/{id}', function ($id) {
    $user = \App\Models\InMemoryUser::find($id);

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
});

// PUT / PATCH /api/users/{id} - Kullanıcı güncelleme (Model aracılığıyla)
Route::match(['put', 'patch'], '/api/users/{id}', function (\Illuminate\Http\Request $request, $id) {
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

    $updatedUser = \App\Models\InMemoryUser::update($id, $validated);

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
});

// DELETE /api/users/{id} - Kullanıcı silme (Model aracılığıyla)
Route::delete('/api/users/{id}', function ($id) {
    $deletedUser = \App\Models\InMemoryUser::delete($id);

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
});

// GET /api/swagger - Swagger UI Arayüzü
Route::get('/api/swagger', function () {
    return view('swagger');
});

// GET /api/swagger.json - OpenAPI 3.0 Spesifikasyonu
Route::get('/api/swagger.json', function () {
    $path = public_path('openapi.json');
    if (file_exists($path)) {
        return response()->file($path, [
            'Content-Type' => 'application/json; charset=utf-8'
        ]);
    }
    return response()->json([
        'status' => 'error',
        'message' => 'Swagger OpenAPI specification file not found'
    ], 404);
});


