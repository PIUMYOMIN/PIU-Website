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

    // Authenticated routes
    Route::middleware('auth:sanctum')->group(function () {
        // Auth routes
        Route::get('/user/profile', [UserController::class, 'profile']);
        Route::put('/user/profile', [UserController::class, 'updateProfile']);
        Route::post('/user/change-password', [UserController::class, 'changePassword']);

        //user logout
        Route::post('logout', [AuthController::class, 'logout']);

        Route::apiResource('users', UserController::class);
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);
        Route::apiResource('courses', CourseController::class);
        Route::post('courses/{course}/isActive', [CourseController::class, 'isActive']);
        Route::post('courses/{course}/application', [CourseController::class, 'application']);
        Route::get('courses/search', [CourseController::class, 'search']);
        Route::apiResource('course-categories', CourseCategoryController::class);
        Route::apiResource('slides', SlideController::class);
        Route::apiResource('assignments', AssignmentController::class);
        Route::apiResource('modules', ModuleController::class);
    });
});