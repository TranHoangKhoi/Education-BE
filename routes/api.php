<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\MajorsController;
use App\Http\Controllers\SubjectTypeController;
use App\Models\Semester;
use App\Models\SubjectType;
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
Route::resource('/v1/semester',SemesterController::class)->except('destroy');

// Khóa học
Route::resource('/v1/course',CourseController::class)->except('destroy');
//Lĩnh Vực
Route::resource('/v1/field',FieldController::class)->except('destroy');
//Ngành học
Route::resource('/v1/majors',MajorsController::class)->except('destroy');
//Lớp
Route::resource('/v1/class',ClassController::class)->except('destroy');
//Loại môn học
Route::resource('/v1/subject-type',SubjectTypeController::class)->except('destroy');
