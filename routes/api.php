<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CourseController;
use App\Http\Controllers\Api\V1\NewsController;
use App\Http\Controllers\Api\V1\TeamController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\SeminarController;


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

Route::prefix('v1')->group(function(){
    Route::resource('/courses',CourseController::class);
    Route::resource('/news',NewsController::class);
    Route::resource('/teams',TeamController::class);
    Route::resource('/events',EventController::class);
    Route::resource('/seminars',SeminarController::class);
});