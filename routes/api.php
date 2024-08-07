<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\TeamController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\SeminarController;
use App\Http\Controllers\Api\V1\SlideController;
use App\Http\Controllers\Api\V1\GalleryController;
use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\PositionController;
use App\Http\Controllers\Api\V1\AdmissionController;
use App\Http\Controllers\Api\V1\BlogController;
use App\Http\Controllers\Api\V1\CampusController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Middleware\Cors;


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


// Route::middleware('auth:sanctum')->get('/users', function (Request $request) {
//     return $request->user();
// });

Route::middleware([Cors::class])->group(function () {
    Route::prefix('v1')->group(function () {
        Route::resource('/courses', CourseController::class);
        Route::resource('/news', NewsController::class);
        Route::resource('/team', TeamController::class);
        Route::resource('/events', EventController::class);
        Route::resource('/seminars', SeminarController::class);
        Route::resource('/slides', SlideController::class);
        Route::resource('/gallery', GalleryController::class);
        Route::resource('/blogs', BlogController::class);
        Route::resource('/campus', CampusController::class);
        Route::resource('/departments', DepartmentController::class);
        Route::resource('/positions', PositionController::class);
        Route::post('/login', [UserController::class, 'apiLogin']);
        Route::post('/register', [UserController::class, 'register']);
        Route::post('/application-form/submit', [AdmissionController::class, 'store']);
        Route::post('/contact/form-submit',[ContactController::class,'store']);
    });

    Route::middleware('auth:api')->prefix('v1')->group(function () {
        Route::resource('/users', UserController::class);
    });
});