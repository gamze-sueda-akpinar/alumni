<?php

use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\UserController;
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

// =========================================================================
// 1. Web Controller Routes with View Layer (/users -> UserController)
//    - [C] GET    /users/create    --> Renders users.create form view
//    - [C] POST   /users           --> Stores new user and redirects to /users
//    - [R] GET    /users           --> Listing all users via users.index view
//    - [R] GET    /users/{id}      --> Single user details via users.show view
//    - [U] GET    /users/{id}/edit --> Renders users.edit form view
//    - [U] PUT    /users/{id}      --> Updates user data and redirects to /users
//    - [D] DELETE /users/{id}      --> Deletes user and redirects to /users
// =========================================================================
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::match(['put', 'patch'], '/users/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

// =========================================================================
// 2. RESTful API Routes (/api/users -> ApiUserController)
// =========================================================================
Route::get('/api/users', [ApiUserController::class, 'index'])->name('api.users.index');
Route::post('/api/users', [ApiUserController::class, 'store'])->name('api.users.store');
Route::get('/api/users/{id}', [ApiUserController::class, 'show'])->name('api.users.show');
Route::match(['put', 'patch'], '/api/users/{id}', [ApiUserController::class, 'update'])->name('api.users.update');
Route::delete('/api/users/{id}', [ApiUserController::class, 'destroy'])->name('api.users.destroy');

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


