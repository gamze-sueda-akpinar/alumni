<?php

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

    // Veritabanı kullanılmadan simüle edilmiş kullanıcı verisi
    $simulatedUser = array_merge([
        'id' => rand(100, 999),
    ], $validated, [
        'created_at' => now()->toIso8601String(),
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'User created successfully (in-memory simulation)',
        'data' => $simulatedUser,
    ], 201);
});
