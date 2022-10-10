<?php

use App\Http\Controllers\SemesterController;
use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Kì học
Route::get('/v1/semester', [SemesterController::class, 'index']);
Route::post('/v1/semester', [SemesterController::class, 'store']);
Route::get('/v1/semester/{id}', [SemesterController::class, 'show']);
Route::patch('/v1/semester/{id}', [SemesterController::class, 'update']);
// Khóa học
Route::get('/v1/course', [CourseController::class, 'index']);
Route::post('/v1/course', [CourseController::class, 'store']);
Route::get('/v1/course/{id}', [CourseController::class, 'show']);
Route::patch('/v1/course/{id}', [CourseController::class, 'update']);

