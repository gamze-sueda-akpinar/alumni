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

Route::post('/api/users', function (\Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'student_number' => 'nullable|string|max:50',
        'graduation_year' => 'nullable|integer',
        'department' => 'nullable|string|max:255',
        'current_company' => 'nullable|string|max:255',
        'current_position' => 'nullable|string|max:255',
    ]);

    $defaultUsers = [
        [
            'id' => 1,
            'name' => 'Gamze Şüeda Akpınar',
            'email' => 'gamze@example.com',
            'student_number' => '2019123456',
            'graduation_year' => 2024,
            'department' => 'Bilgisayar Mühendisliği',
            'current_company' => 'Google',
            'current_position' => 'Software Engineer',
            'city' => 'İstanbul',
            'status' => 'approved',
            'created_at' => '2026-09-30T06:00:00+00:00',
        ],
        [
            'id' => 2,
            'name' => 'Ahmet Yılmaz',
            'email' => 'ahmet.yilmaz@example.com',
            'student_number' => '170102045',
            'graduation_year' => 2021,
            'department' => 'Bilgisayar Mühendisliği',
            'current_company' => 'Trendyol',
            'current_position' => 'Senior Backend Developer',
            'city' => 'İstanbul',
            'status' => 'approved',
            'created_at' => '2026-09-30T06:00:00+00:00',
        ],
        [
            'id' => 3,
            'name' => 'Elif Kaya',
            'email' => 'elif.kaya@example.com',
            'student_number' => '190104012',
            'graduation_year' => 2023,
            'department' => 'Yazılım Mühendisliği',
            'current_company' => 'Getir',
            'current_position' => 'Frontend Developer',
            'city' => 'İzmir',
            'status' => 'approved',
            'created_at' => '2026-09-30T06:00:00+00:00',
        ],
    ];

    $users = Cache::get('api_users_list', $defaultUsers);

    $nextId = count($users) > 0 ? max(array_column($users, 'id')) + 1 : 1;

    $newUser = array_merge([
        'id' => $nextId,
    ], $validated, [
        'city' => $request->input('city', 'İstanbul'),
        'status' => 'approved',
        'created_at' => now()->toIso8601String(),
    ]);

    // Yeni kullanıcıyı listeye ekle ve kalıcı olarak sakla
    $users[] = $newUser;
    Cache::forever('api_users_list', $users);

    return response()->json([
        'status' => 'success',
        'message' => 'User created and saved successfully',
        'data' => $newUser,
    ], 201);
});

Route::get('/api/users', function () {
    $defaultUsers = [
        [
            'id' => 1,
            'name' => 'Gamze Şüeda Akpınar',
            'email' => 'gamze@example.com',
            'student_number' => '2019123456',
            'graduation_year' => 2024,
            'department' => 'Bilgisayar Mühendisliği',
            'current_company' => 'Google',
            'current_position' => 'Software Engineer',
            'city' => 'İstanbul',
            'status' => 'approved',
            'created_at' => '2026-09-30T06:00:00+00:00',
        ],
        [
            'id' => 2,
            'name' => 'Ahmet Yılmaz',
            'email' => 'ahmet.yilmaz@example.com',
            'student_number' => '170102045',
            'graduation_year' => 2021,
            'department' => 'Bilgisayar Mühendisliği',
            'current_company' => 'Trendyol',
            'current_position' => 'Senior Backend Developer',
            'city' => 'İstanbul',
            'status' => 'approved',
            'created_at' => '2026-09-30T06:00:00+00:00',
        ],
        [
            'id' => 3,
            'name' => 'Elif Kaya',
            'email' => 'elif.kaya@example.com',
            'student_number' => '190104012',
            'graduation_year' => 2023,
            'department' => 'Yazılım Mühendisliği',
            'current_company' => 'Getir',
            'current_position' => 'Frontend Developer',
            'city' => 'İzmir',
            'status' => 'approved',
            'created_at' => '2026-09-30T06:00:00+00:00',
        ],
    ];

    $users = Cache::get('api_users_list', $defaultUsers);

    return response()->json([
        'status' => 'success',
        'message' => 'Users listed successfully',
        'total' => count($users),
        'data' => $users,
    ], 200);
});

// GET /api/users/{id} - Tekil kullanıcı getirme
Route::get('/api/users/{id}', function ($id) {
    $users = Cache::get('api_users_list', []);

    foreach ($users as $user) {
        if ((string) $user['id'] === (string) $id) {
            return response()->json([
                'status' => 'success',
                'data' => $user,
            ], 200);
        }
    }

    return response()->json([
        'status' => 'error',
        'message' => "User with ID {$id} not found",
    ], 404);
});

// PUT / PATCH /api/users/{id} - Kullanıcı güncelleme
Route::match(['put', 'patch'], '/api/users/{id}', function (\Illuminate\Http\Request $request, $id) {
    $users = Cache::get('api_users_list', []);

    $userIndex = null;
    foreach ($users as $index => $user) {
        if ((string) $user['id'] === (string) $id) {
            $userIndex = $index;
            break;
        }
    }

    if ($userIndex === null) {
        return response()->json([
            'status' => 'error',
            'message' => "User with ID {$id} not found",
        ], 404);
    }

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

    // Mevcut alanların üzerine sadece gönderilen yeni alanları güncelle
    $updatedUser = array_merge($users[$userIndex], $validated, [
        'updated_at' => now()->toIso8601String(),
    ]);

    $users[$userIndex] = $updatedUser;
    Cache::forever('api_users_list', $users);

    return response()->json([
        'status' => 'success',
        'message' => "User with ID {$id} updated successfully",
        'data' => $updatedUser,
    ], 200);
});
