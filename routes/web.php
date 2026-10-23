<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\ApiAnnouncementController;
use App\Http\Controllers\ApiDepartmentController;
use App\Http\Controllers\ApiEventController;
use App\Http\Controllers\ApiExperienceController;
use App\Http\Controllers\ApiFacultyController;
use App\Http\Controllers\ApiJobApplicationController;
use App\Http\Controllers\ApiJobPostingController;
use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobPostingController;
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

// =========================================================================
// 3. Web Controller Routes with View Layer (/announcements -> AnnouncementController)
//    - [C] GET    /announcements/create    --> Renders announcements.create form view
//    - [C] POST   /announcements           --> Stores new announcement and redirects
//    - [R] GET    /announcements           --> Listing all announcements via index view
//    - [R] GET    /announcements/{id}      --> Single announcement details via show view
//    - [U] GET    /announcements/{id}/edit --> Renders announcements.edit form view
//    - [U] PUT    /announcements/{id}      --> Updates announcement data and redirects
//    - [D] DELETE /announcements/{id}      --> Deletes announcement and redirects
// =========================================================================
Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
Route::get('/announcements/{id}', [AnnouncementController::class, 'show'])->name('announcements.show');
Route::get('/announcements/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
Route::match(['put', 'patch'], '/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

// =========================================================================
// 4. RESTful API Routes (/api/announcements -> ApiAnnouncementController)
// =========================================================================
Route::get('/api/announcements', [ApiAnnouncementController::class, 'index'])->name('api.announcements.index');
Route::post('/api/announcements', [ApiAnnouncementController::class, 'store'])->name('api.announcements.store');
Route::get('/api/announcements/{id}', [ApiAnnouncementController::class, 'show'])->name('api.announcements.show');
Route::match(['put', 'patch'], '/api/announcements/{id}', [ApiAnnouncementController::class, 'update'])->name('api.announcements.update');
Route::delete('/api/announcements/{id}', [ApiAnnouncementController::class, 'destroy'])->name('api.announcements.destroy');

// =========================================================================
// 5. Web Controller Routes with View Layer (/job-postings -> JobPostingController)
//    - [C] GET    /job-postings/create    --> Renders job_postings.create form view
//    - [C] POST   /job-postings           --> Stores new job posting and redirects
//    - [R] GET    /job-postings           --> Listing all job postings via index view
//    - [R] GET    /job-postings/{id}      --> Single job posting details via show view
//    - [U] GET    /job-postings/{id}/edit --> Renders job_postings.edit form view
//    - [U] PUT    /job-postings/{id}      --> Updates job posting data and redirects
//    - [D] DELETE /job-postings/{id}      --> Deletes job posting and redirects
// =========================================================================
Route::get('/job-postings', [JobPostingController::class, 'index'])->name('job-postings.index');
Route::get('/job-postings/create', [JobPostingController::class, 'create'])->name('job-postings.create');
Route::post('/job-postings', [JobPostingController::class, 'store'])->name('job-postings.store');
Route::get('/job-postings/{id}', [JobPostingController::class, 'show'])->name('job-postings.show');
Route::get('/job-postings/{id}/edit', [JobPostingController::class, 'edit'])->name('job-postings.edit');
Route::match(['put', 'patch'], '/job-postings/{id}', [JobPostingController::class, 'update'])->name('job-postings.update');
Route::delete('/job-postings/{id}', [JobPostingController::class, 'destroy'])->name('job-postings.destroy');

// =========================================================================
// 6. RESTful API Routes (/api/job-postings -> ApiJobPostingController)
// =========================================================================
Route::prefix('api/job-postings')->name('api.job-postings.')->group(function () {
    Route::get('/', [ApiJobPostingController::class, 'index'])->name('index');
    Route::post('/', [ApiJobPostingController::class, 'store'])->name('store');
    Route::get('/{id}', [ApiJobPostingController::class, 'show'])->name('show');
    Route::match(['put', 'patch'], '/{id}', [ApiJobPostingController::class, 'update'])->name('update');
    Route::delete('/{id}', [ApiJobPostingController::class, 'destroy'])->name('destroy');
    // Nested: Applications under Job Posting
    Route::get('/{id}/applications', [ApiJobApplicationController::class, 'forJobPosting'])->name('applications.index');
    Route::post('/{id}/applications', [ApiJobApplicationController::class, 'storeForJobPosting'])->name('applications.store');
});

// =========================================================================
// 7. Direct & Nested Routes: Faculties & Departments
//    Direct:
//      - GET  /api/faculties                     --> ApiFacultyController@index
//      - GET  /api/faculties/{id}                --> ApiFacultyController@show
//      - GET  /api/departments                   --> ApiDepartmentController@index
//      - GET  /api/departments/{id}              --> ApiDepartmentController@show
//    Nested:
//      - GET  /api/faculties/{id}/departments    --> ApiFacultyController@departments
//      - POST /api/faculties/{id}/departments    --> ApiFacultyController@storeDepartment
//      - GET  /api/departments/{id}/alumni       --> ApiDepartmentController@alumni
// =========================================================================
Route::prefix('api/faculties')->name('api.faculties.')->group(function () {
    Route::get('/', [ApiFacultyController::class, 'index'])->name('index');
    Route::get('/{id}', [ApiFacultyController::class, 'show'])->name('show');
    // Nested: Departments under Faculty
    Route::get('/{id}/departments', [ApiFacultyController::class, 'departments'])->name('departments');
    Route::post('/{id}/departments', [ApiFacultyController::class, 'storeDepartment'])->name('departments.store');
});

Route::prefix('api/departments')->name('api.departments.')->group(function () {
    Route::get('/', [ApiDepartmentController::class, 'index'])->name('index');
    Route::get('/{id}', [ApiDepartmentController::class, 'show'])->name('show');
    // Nested: Alumni under Department
    Route::get('/{id}/alumni', [ApiDepartmentController::class, 'alumni'])->name('alumni');
});

// =========================================================================
// 8. Direct Routes: Experiences
//    Direct:
//      - GET    /api/experiences/{id}            --> ApiExperienceController@show
//      - PUT    /api/experiences/{id}            --> ApiExperienceController@update
//      - DELETE /api/experiences/{id}            --> ApiExperienceController@destroy
// =========================================================================
Route::prefix('api/experiences')->name('api.experiences.')->group(function () {
    Route::get('/{id}', [ApiExperienceController::class, 'show'])->name('show');
    Route::match(['put', 'patch'], '/{id}', [ApiExperienceController::class, 'update'])->name('update');
    Route::delete('/{id}', [ApiExperienceController::class, 'destroy'])->name('destroy');
});

// =========================================================================
// 9. Direct Routes: Events
//    Direct:
//      - GET    /api/events                      --> ApiEventController@index
//      - POST   /api/events                      --> ApiEventController@store
//      - GET    /api/events/{id}                 --> ApiEventController@show
//      - PUT    /api/events/{id}                 --> ApiEventController@update
//      - DELETE /api/events/{id}                 --> ApiEventController@destroy
// =========================================================================
Route::prefix('api/events')->name('api.events.')->group(function () {
    Route::get('/', [ApiEventController::class, 'index'])->name('index');
    Route::post('/', [ApiEventController::class, 'store'])->name('store');
    Route::get('/{id}', [ApiEventController::class, 'show'])->name('show');
    Route::match(['put', 'patch'], '/{id}', [ApiEventController::class, 'update'])->name('update');
    Route::delete('/{id}', [ApiEventController::class, 'destroy'])->name('destroy');
});

// =========================================================================
// 10. Nested Routes: User Scoped Child Resources (/api/users/{user}/...)
//     - Profile (1:1):
//       - GET        /api/users/{id}/profile      --> ApiUserController@profile
//       - PUT/PATCH  /api/users/{id}/profile      --> ApiUserController@updateProfile
//     - Experiences (1:N):
//       - GET        /api/users/{id}/experiences  --> ApiUserController@experiences
//       - POST       /api/users/{id}/experiences  --> ApiUserController@storeExperience
//     - Job Postings (1:N):
//       - GET        /api/users/{id}/job-postings --> ApiUserController@jobPostings
//       - POST       /api/users/{id}/job-postings --> ApiUserController@storeJobPosting
// =========================================================================
Route::prefix('api/users/{id}')->name('api.users.nested.')->group(function () {
    // Nested Profile
    Route::get('/profile', [ApiUserController::class, 'profile'])->name('profile.show');
    Route::match(['put', 'patch'], '/profile', [ApiUserController::class, 'updateProfile'])->name('profile.update');

    // Nested Experiences
    Route::get('/experiences', [ApiUserController::class, 'experiences'])->name('experiences.index');
    Route::post('/experiences', [ApiUserController::class, 'storeExperience'])->name('experiences.store');

    // Nested Job Postings
    Route::get('/job-postings', [ApiUserController::class, 'jobPostings'])->name('job-postings.index');
    Route::post('/job-postings', [ApiUserController::class, 'storeJobPosting'])->name('job-postings.store');

    // Nested Applications
    Route::get('/applications', [ApiUserController::class, 'applications'])->name('applications.index');
    Route::post('/applications', [ApiUserController::class, 'storeApplication'])->name('applications.store');
});

// =========================================================================
// 11. Direct Routes: Job Applications (/api/applications)
//     Direct:
//       - GET    /api/applications             --> ApiJobApplicationController@index
//       - POST   /api/applications             --> ApiJobApplicationController@store
//       - GET    /api/applications/{id}        --> ApiJobApplicationController@show
//       - PUT    /api/applications/{id}        --> ApiJobApplicationController@update
//       - DELETE /api/applications/{id}        --> ApiJobApplicationController@destroy
// =========================================================================
Route::prefix('api/applications')->name('api.applications.')->group(function () {
    Route::get('/', [ApiJobApplicationController::class, 'index'])->name('index');
    Route::post('/', [ApiJobApplicationController::class, 'store'])->name('store');
    Route::get('/{id}', [ApiJobApplicationController::class, 'show'])->name('show');
    Route::match(['put', 'patch'], '/{id}', [ApiJobApplicationController::class, 'update'])->name('update');
    Route::delete('/{id}', [ApiJobApplicationController::class, 'destroy'])->name('destroy');
});

// =========================================================================
// 12. Web Controller Routes with View Layer (/applications -> JobApplicationController)
//    - [C] GET    /applications/create       --> Renders applications.create form view
//    - [C] POST   /applications              --> Stores new application
//    - [R] GET    /applications              --> Listing all applications via index view
//    - [R] GET    /applications/{id}         --> Single application details via show view
//    - [U] POST   /applications/{id}/status  --> Updates application status & notes
//    - [D] DELETE /applications/{id}         --> Deletes / withdraws application
// =========================================================================
Route::get('/applications', [JobApplicationController::class, 'index'])->name('applications.index');
Route::get('/applications/create', [JobApplicationController::class, 'create'])->name('applications.create');
Route::post('/applications', [JobApplicationController::class, 'store'])->name('applications.store');
Route::get('/applications/{id}', [JobApplicationController::class, 'show'])->name('applications.show');
Route::post('/applications/{id}/status', [JobApplicationController::class, 'updateStatus'])->name('applications.status');
Route::delete('/applications/{id}', [JobApplicationController::class, 'destroy'])->name('applications.destroy');

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


