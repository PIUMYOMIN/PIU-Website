<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TeamV1Controller;
use App\Http\Controllers\Api\ContactV1Controller;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseCategoryController;
use App\Http\Controllers\Api\SlideController;
use App\Http\Controllers\Api\AssignmentController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\AdmissionController;
use App\Http\Controllers\Api\EventsController;
use App\Http\Controllers\Api\CurriculumController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\YearController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\PositionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Explicitly handle CORS preflight for mobile/edge environments.
Route::options('v1/{any}', function () {
    return response('', 204);
})->where('any', '.*');

// ==================== V1 (Legacy public endpoints) ====================
Route::prefix('v1')->group(function () {
    // Legacy Faculty/Team + Contact (keep paths unchanged)
    Route::get('team', [TeamV1Controller::class, 'index']);
    Route::get('team/{slug}', [TeamV1Controller::class, 'show']);
    Route::post('contact/form-submit', [ContactV1Controller::class, 'store'])->middleware('recaptcha');

    // Public routes
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    // ==================== PUBLIC ROUTES ====================

    // Courses - Public GET routes
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{course}', [CourseController::class, 'show']);
    Route::get('courses/search', [CourseController::class, 'search']);

    // Slides - Public GET routes
    Route::get('slides', [SlideController::class, 'index']);
    Route::get('slides/{slide}', [SlideController::class, 'show']);

    // News - Public GET routes
    Route::get('news', [NewsController::class, 'index']);
    Route::get('news/{id}', [NewsController::class, 'show']);
    Route::get('news/slug/{slug}', [NewsController::class, 'showBySlug']);
    Route::get('news/search', [NewsController::class, 'search']);

    // Blogs - Public GET routes
    Route::get('blogs', [BlogController::class, 'index']);
    Route::get('blogs/{id}', [BlogController::class, 'show']);
    Route::get('blogs/slug/{slug}', [BlogController::class, 'showBySlug']);
    Route::get('blogs/search', [BlogController::class, 'search']);

    // Course Categories - Public GET routes
    Route::get('course-categories', [CourseCategoryController::class, 'index']);
    Route::get('course-categories/{id}', [CourseCategoryController::class, 'show']);

    // Galleries - Public GET routes
    Route::get('gallery', [GalleryController::class, 'index']);
    Route::get('gallery/recent/{limit?}', [GalleryController::class, 'recent']);

    // Events - Public GET routes
    Route::get('events', [EventsController::class, 'index']);

    // Admissions - Public submit route
    Route::post('admissions', [AdmissionController::class, 'store'])->middleware('recaptcha');

    // ==================== AUTHENTICATED ROUTES ====================
    Route::middleware('auth:sanctum')->group(function () {
        // Auth routes
        Route::get('/user/profile', [UserController::class, 'profile']);
        Route::put('/user/profile', [UserController::class, 'updateProfile']);
        Route::post('/user/change-password', [UserController::class, 'changePassword']);
        Route::post('logout', [AuthController::class, 'logout']);

        // ==================== COURSES ====================
        Route::post('courses', [CourseController::class, 'store'])->middleware('role:admin|teacher|registrar');
        Route::put('courses/{course}', [CourseController::class, 'update'])->middleware('role:admin|teacher|registrar');
        Route::patch('courses/{course}', [CourseController::class, 'update'])->middleware('role:admin|teacher|registrar');
        Route::delete('courses/{course}', [CourseController::class, 'destroy'])->middleware('role:admin|teacher|registrar');
        Route::post('courses/{course}/isActive', [CourseController::class, 'isActive'])->middleware('role:admin|teacher|registrar');
        Route::post('courses/{course}/application', [CourseController::class, 'application'])->middleware('role:admin|teacher|registrar');

        // ==================== SLIDES ====================
        Route::post('slides', [SlideController::class, 'store'])->middleware('role:admin');
        Route::put('slides/{slide}', [SlideController::class, 'update'])->middleware('role:admin');
        Route::patch('slides/{slide}', [SlideController::class, 'update'])->middleware('role:admin');
        Route::delete('slides/{slide}', [SlideController::class, 'destroy'])->middleware('role:admin');
        Route::post('slides/{slide}/toggle-active', [SlideController::class, 'toggleActive'])->middleware('role:admin');
        Route::post('slides/update-order', [SlideController::class, 'updateOrder'])->middleware('role:admin');

        // ==================== NEWS ====================
        Route::post('news', [NewsController::class, 'store'])->middleware('role:admin|teacher|registrar');
        Route::put('news/{news}', [NewsController::class, 'update'])->middleware('role:admin|teacher|registrar');
        Route::patch('news/{news}', [NewsController::class, 'update'])->middleware('role:admin|teacher|registrar');
        Route::delete('news/{news}', [NewsController::class, 'destroy'])->middleware('role:admin|teacher|registrar');
        Route::post('news/{news}/toggle-active', [NewsController::class, 'toggleActive'])->middleware('role:admin|teacher|registrar');

        // ==================== BLOGS ====================
        Route::post('blogs', [BlogController::class, 'store'])->middleware('role:admin|teacher|registrar');
        Route::put('blogs/{blog}', [BlogController::class, 'update'])->middleware('role:admin|teacher|registrar');
        Route::patch('blogs/{blog}', [BlogController::class, 'update'])->middleware('role:admin|teacher|registrar');
        Route::delete('blogs/{blog}', [BlogController::class, 'destroy'])->middleware('role:admin|teacher|registrar');
        Route::post('blogs/{blog}/toggle-active', [BlogController::class, 'toggleActive'])->middleware('role:admin|teacher|registrar');
        Route::post('blogs/upload-image', [BlogController::class, 'uploadImage'])->middleware('role:admin|teacher|registrar');

        // ==================== COURSE CATEGORIES ====================
        Route::post('course-categories', [CourseCategoryController::class, 'store'])->middleware('role:admin|registrar');
        Route::put('course-categories/{category}', [CourseCategoryController::class, 'update'])->middleware('role:admin|registrar');
        Route::patch('course-categories/{category}', [CourseCategoryController::class, 'update'])->middleware('role:admin|registrar');
        Route::delete('course-categories/{category}', [CourseCategoryController::class, 'destroy'])->middleware('role:admin|registrar');

        // ==================== OTHER RESOURCES ====================
        Route::apiResource('users', UserController::class)->middleware('role:admin');
        Route::get('users/role-audit', [UserController::class, 'auditRoles'])->middleware('role:admin');
        Route::post('users/assign-missing-roles', [UserController::class, 'assignMissingRoles'])->middleware('role:admin');
        Route::apiResource('roles', RoleController::class)->middleware('role:admin');
        Route::apiResource('permissions', PermissionController::class)->middleware('role:admin');
        Route::apiResource('assignments', AssignmentController::class)->middleware('role:admin|teacher');
        Route::apiResource('modules', ModuleController::class)->middleware('role:admin|teacher|registrar');
        Route::apiResource('curriculums', CurriculumController::class)->middleware('role:admin|teacher|registrar');
        Route::apiResource('students', StudentController::class)->middleware('role:admin|teacher|registrar');
        Route::apiResource('teams', TeamController::class)->middleware('role:admin');
        Route::post('teams/{team}/toggle-active', [TeamController::class, 'toggleActive'])->middleware('role:admin');

        Route::get('years', [YearController::class, 'index'])->middleware('role:admin|teacher|registrar');
        Route::get('departments', [DepartmentController::class, 'index'])->middleware('role:admin|teacher|registrar');
        Route::get('positions', [PositionController::class, 'index'])->middleware('role:admin|teacher|registrar');

        // Admissions (admin/staff use)
        Route::get('admissions', [AdmissionController::class, 'index'])->middleware('role:admin|registrar');
        Route::get('admissions/{id}', [AdmissionController::class, 'show'])->middleware('role:admin|registrar');
        Route::put('admissions/{id}', [AdmissionController::class, 'update'])->middleware('role:admin|registrar');
        Route::patch('admissions/{id}', [AdmissionController::class, 'update'])->middleware('role:admin|registrar');

        // ==================== GALLERIES ====================
        Route::post('gallery', [GalleryController::class, 'store'])->middleware('role:admin|teacher|registrar');
        Route::put('gallery/{id}', [GalleryController::class, 'update'])->middleware('role:admin|teacher|registrar');
        Route::patch('gallery/{id}', [GalleryController::class, 'update'])->middleware('role:admin|teacher|registrar');
        Route::delete('gallery/{id}', [GalleryController::class, 'destroy'])->middleware('role:admin|teacher|registrar');
        Route::post('gallery/{id}/toggle-active', [GalleryController::class, 'toggleActive'])->middleware('role:admin|teacher|registrar');
        Route::get('gallery/tag/{tag}', [GalleryController::class, 'byTag'])->middleware('role:admin|teacher|registrar');
        Route::get('gallery/recent/{limit?}', [GalleryController::class, 'recent'])->middleware('role:admin|teacher|registrar');
    });
});