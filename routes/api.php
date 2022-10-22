<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\MajorsController;
use App\Http\Controllers\NotifyCateController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\SubjectTypeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
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
Route::resource('/course',CourseController::class)->except('destroy');
//Lĩnh Vực
Route::resource('/field',FieldController::class)->except('destroy');
//Ngành học
Route::resource('/majors',MajorsController::class)->except('destroy');
//Lớp
Route::resource('/class',ClassController::class)->except('destroy');
//Loại môn học
Route::resource('/subject-type',SubjectTypeController::class)->except('destroy');
//Danh mục thông báo
Route::resource('/notify_cate',NotifyCateController::class)->except('destroy');
//Thong bao
Route::resource('/notify',NotifyController::class);
Route::resource('/student',StudentController::class);
Route::resource('/subject',SubjectController::class);
