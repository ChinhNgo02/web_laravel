<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Middleware\CheckLoginMiddleware;
use App\Http\Middleware\CheckSuperAdminMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::resource('courses', CourseController::class);
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'processLogin'])->name('process_login');
Route::group([
    'middleware' => CheckLoginMiddleware::class,
], function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::group(['prefix' => 'courses', 'as' => 'course.'], function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::post('/create', [CourseController::class, 'store'])->name('store');
        // Route::delete('/destroy/{course}', [CourseController::class, 'destroy'])->name('destroy');
        Route::get('/edit/{course}', [CourseController::class, 'edit'])->name('edit');
        Route::PUT('/edit/{course}', [CourseController::class, 'update'])->name('update');
    });

    Route::get('courses/api', [CourseController::class, 'api'])->name('course.api');
    Route::get('courses/api/name', [CourseController::class, 'apiName'])->name('course.api.name');

    Route::resource('students', StudentController::class)->except([
        'show',
        'destroy',
    ]);
    Route::get('students/api', [StudentController::class, 'api'])->name('students.api');

    Route::group([
        'middleware' => CheckSuperAdminMiddleware::class,
    ], function () {
        // Route::group(['prefix' => 'courses', 'as' => 'course.'], function () {
        //     Route::delete('/destroy/{course}', [CourseController::class, 'destroy'])->name('destroy');
        // });
        Route::delete('courses/destroy/{course}', [CourseController::class, 'destroy'])->name('course.destroy');

        Route::delete('students/{course}', [StudentController::class, 'destroy'])->name('students.destroy');
    });
});