<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V2\RoleController;
use App\Http\Controllers\Api\V2\PermissionController;
use App\Http\Controllers\Api\V2\UserController;
use App\Http\Controllers\Api\V2\CourseController;
use App\Http\Controllers\Api\V2\CourseCategoryController;
use App\Http\Controllers\Api\V2\SlideController;
use App\Http\Controllers\Api\V2\AssignmentController;
use App\Http\Controllers\Api\V2\ModuleController;
use App\Http\Controllers\Api\V2\AuthController;
use App\Http\Controllers\Api\V2\BlogController;
use App\Http\Controllers\Api\V2\NewsController;
use App\Http\Controllers\Api\V2\GalleryController;


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

Route::prefix('v2')->group(function () {
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
    Route::get('galleries', [GalleryController::class, 'index']);
    Route::get('galleries/tag/{tag}', [GalleryController::class, 'byTag']);
    Route::get('galleries/recent/{limit?}', [GalleryController::class, 'recent']);

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

        // ==================== GALLERIES ====================
        Route::post('galleries', [GalleryController::class, 'store']);
        Route::put('galleries/{id}', [GalleryController::class, 'update']);
        Route::patch('galleries/{id}', [GalleryController::class, 'update']);
        Route::delete('galleries/{id}', [GalleryController::class, 'destroy']);
        Route::post('galleries/{id}/toggle-active', [GalleryController::class, 'toggleActive']);
    });
});