<?php

use App\Http\Controllers\ClassController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\MajorsController;
use App\Http\Controllers\SubjectTypeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LecturersController;
use App\Http\Controllers\ScoresController;
use App\Http\Controllers\CaseScoreController;
use App\Http\Controllers\DetailScoresController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\NotifyCateController;
use App\Http\Controllers\NotifyController;
use App\Models\Information;
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

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Private Route
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/logout', [AuthController::class, 'logOut']);
    Route::resource('/student',StudentController::class);
    Route::resource('/scores',ScoresController::class)->only('index', 'show');
    Route::resource('/casecore',CaseScoreController::class)->only('index', 'show');
    Route::resource('/detailscorse',DetailScoresController::class)->only('index', 'show');
    Route::get('/listScore/{id}', [ScoresController::class, 'loadListScoreByIdStudent']);
    Route::resource('/subject',SubjectController::class)->only('index', 'show');

    //K?? h???c
    Route::resource('/semester',SemesterController::class)->only('show', 'index');
    // Kh??a h???c
    Route::resource('/course',CourseController::class)->only('show', 'index');
    //L??nh V???c
    Route::resource('/field',FieldController::class)->only('show', 'index');
    //Ng??nh h???c
    Route::resource('/majors',MajorsController::class)->only('show', 'index');
    //L???p
    Route::resource('/class',ClassController::class)->only('show', 'index');
    //Lo???i m??n h???c
    Route::resource('/subject-type',SubjectTypeController::class)->only('show', 'index');

    Route::resource('/information',InformationController::class);
    Route::middleware('LecturersCheck')->group(function() {
        Route::resource('/detailscorse',DetailScoresController::class);
        Route::resource('/student',StudentController::class)->only('index', 'show');
        Route::resource('/scores',ScoresController::class);
        Route::resource('/casecore',CaseScoreController::class);
        Route::get('/listScore/{id}', [ScoresController::class, 'loadListScoreByIdStudent']);
        // Route::get('/listSubject/{id}', [SubjectController::class, 'loadListSubjectByClass']);
        Route::resource('/subject',SubjectController::class);
    });

    // Check Medium
    Route::middleware('AdminCheck')->group(function() {
        Route::resource('/student',StudentController::class)->only('index', 'show');
        Route::resource('/lecturers',LecturersController::class)->only('index', 'show');
        Route::resource('/scores',ScoresController::class);
        Route::resource('/casecore',CaseScoreController::class);
        Route::resource('/detailscorse',DetailScoresController::class);
        Route::resource('/information',InformationController::class);
        Route::resource('/subject',SubjectController::class);
        Route::resource('/semester',SemesterController::class);
        // Kh??a h???c
        Route::resource('/course',CourseController::class);
        //L??nh V???c
        Route::resource('/field',FieldController::class);
        //Ng??nh h???c
        Route::resource('/majors',MajorsController::class);
        //L???p
        Route::resource('/class',ClassController::class);
        //Lo???i m??n h???c
        Route::resource('/subject-type',SubjectTypeController::class);
        //Danh m???c th??ng b??o
        Route::resource('/notification',NotifyCateController::class);
        // Route::get('/search/{name}',[NotifyCateController::class,'search']);
        //Th??ng B??o
        Route::resource('/notify',NotifyController::class);



            // Check Master
            Route::middleware('MasterAdminCheck')->group(function() {
                Route::resource('/admin',AdminController::class);
                Route::resource('/student',StudentController::class);
                Route::resource('/lecturers',LecturersController::class);
            });
    });




    // Route::resource('/admin',AdminController::class);

    // Route::resource('/student',StudentController::class);
    // Route::resource('/subject',SubjectController::class)->only('index', 'show');
    // Route::resource('/lecturers',LecturersController::class);
});
