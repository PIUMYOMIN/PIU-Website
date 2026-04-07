<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TeamController as V1TeamController;
use App\Http\Controllers\Api\V1\ContactController as V1ContactController;
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
use App\Http\Controllers\Api\V2\EventsController;
use App\Http\Controllers\Api\V2\CurriculumController as V2CurriculumController;
use App\Http\Controllers\Api\V2\StudentController as V2StudentController;
use App\Http\Controllers\Api\V2\TeamController as V2TeamController;
use App\Http\Controllers\Api\V2\YearController as V2YearController;
use App\Http\Controllers\Api\V2\DepartmentController as V2DepartmentController;
use App\Http\Controllers\Api\V2\PositionController as V2PositionController;


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

// ==================== V1 (Legacy public endpoints) ====================
Route::prefix('v1')->middleware('recaptcha')->group(function () {
    // Faculty/Team
    Route::get('team', [V1TeamController::class, 'index']);
    Route::get('team/{slug}', [V1TeamController::class, 'show']);

    // Contact form (legacy)
    Route::post('contact/form-submit', [V1ContactController::class, 'store']);
});

// Note: routes in routes/api.php are automatically prefixed with /api by Laravel.
// So this group should be /api/v2 (not /api/api/v2).
Route::prefix('v2')->middleware('recaptcha')->group(function () {
    // Public routes
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

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
    Route::post('admissions', [AdmissionController::class, 'store']);

    // ==================== AUTHENTICATED ROUTES ====================
    Route::middleware('auth:sanctum')->group(function () {
        // Auth routes
        Route::get('/user/profile', [UserController::class, 'profile']);
        Route::put('/user/profile', [UserController::class, 'updateProfile']);
        Route::post('/user/change-password', [UserController::class, 'changePassword']);
        Route::post('logout', [AuthController::class, 'logout']);

        // ==================== COURSES ====================
        Route::post('courses', [CourseController::class, 'store']);
        Route::put('courses/{course}', [CourseController::class, 'update']);
        Route::patch('courses/{course}', [CourseController::class, 'update']);
        Route::delete('courses/{course}', [CourseController::class, 'destroy']);
        Route::post('courses/{course}/isActive', [CourseController::class, 'isActive']);
        Route::post('courses/{course}/application', [CourseController::class, 'application']);

        // ==================== SLIDES ====================
        Route::post('slides', [SlideController::class, 'store']);
        Route::put('slides/{slide}', [SlideController::class, 'update']);
        Route::patch('slides/{slide}', [SlideController::class, 'update']);
        Route::delete('slides/{slide}', [SlideController::class, 'destroy']);
        Route::post('slides/{slide}/toggle-active', [SlideController::class, 'toggleActive']);
        Route::post('slides/update-order', [SlideController::class, 'updateOrder']);

        // ==================== NEWS ====================
        Route::post('news', [NewsController::class, 'store']);
        Route::put('news/{news}', [NewsController::class, 'update']);
        Route::patch('news/{news}', [NewsController::class, 'update']);
        Route::delete('news/{news}', [NewsController::class, 'destroy']);
        Route::post('news/{news}/toggle-active', [NewsController::class, 'toggleActive']);

        // ==================== BLOGS ====================
        Route::post('blogs', [BlogController::class, 'store']);
        Route::put('blogs/{blog}', [BlogController::class, 'update']);
        Route::patch('blogs/{blog}', [BlogController::class, 'update']);
        Route::delete('blogs/{blog}', [BlogController::class, 'destroy']);
        Route::post('blogs/{blog}/toggle-active', [BlogController::class, 'toggleActive']);
        Route::post('blogs/upload-image', [BlogController::class, 'uploadImage']);

        // ==================== COURSE CATEGORIES ====================
        Route::post('course-categories', [CourseCategoryController::class, 'store']);
        Route::put('course-categories/{category}', [CourseCategoryController::class, 'update']);
        Route::patch('course-categories/{category}', [CourseCategoryController::class, 'update']);
        Route::delete('course-categories/{category}', [CourseCategoryController::class, 'destroy']);

        // ==================== OTHER RESOURCES ====================
        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);
        Route::apiResource('assignments', AssignmentController::class);
        Route::apiResource('modules', ModuleController::class);
        Route::apiResource('curriculums', V2CurriculumController::class);
        Route::apiResource('students', V2StudentController::class);
        Route::apiResource('teams', V2TeamController::class);
        Route::post('teams/{team}/toggle-active', [V2TeamController::class, 'toggleActive']);

        Route::get('years', [V2YearController::class, 'index']);
        Route::get('departments', [V2DepartmentController::class, 'index']);
        Route::get('positions', [V2PositionController::class, 'index']);

        // Admissions (admin/staff use)
        Route::get('admissions', [AdmissionController::class, 'index']);
        Route::get('admissions/{id}', [AdmissionController::class, 'show']);
        Route::put('admissions/{id}', [AdmissionController::class, 'update']);
        Route::patch('admissions/{id}', [AdmissionController::class, 'update']);

        // ==================== GALLERIES ====================
        Route::post('gallery', [GalleryController::class, 'store']);
        Route::put('gallery/{id}', [GalleryController::class, 'update']);
        Route::patch('gallery/{id}', [GalleryController::class, 'update']);
        Route::delete('gallery/{id}', [GalleryController::class, 'destroy']);
        Route::post('gallery/{id}/toggle-active', [GalleryController::class, 'toggleActive']);
        Route::get('gallery/tag/{tag}', [GalleryController::class, 'byTag']);
        Route::get('gallery/recent/{limit?}', [GalleryController::class, 'recent']);
    });
});