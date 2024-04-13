<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['App\Http\Middleware\Authenticate'])->group(function () {
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');



    });
    Route::middleware(['App\Http\Middleware\CheckAdmin'])->group(function () {
        Route::get('/admin', function () {
            // Chỉ các admin mới có thể truy cập route này
        });
    });
    Route::controller(StudentController::class)->group(function () {
    Route::get('student/list', 'student')->middleware('auth')->name('student/list'); // list student
    Route::get('student/grid', 'studentGrid')->middleware('auth')->name('student/grid'); // grid student
    Route::get('student/add/page', 'studentAdd')->middleware('auth')->name('student/add/page'); // page student
    Route::post('student/add/save', 'studentSave')->name('student/add/save'); // save record student
    Route::get('student/edit/{id}', 'studentEdit'); // view for edit
    Route::post('student/update', 'studentUpdate')->name('student/update'); // update record student
    Route::post('/student/delete', 'delete')->name('student.delete');
    Route::get('student/profile/{id}', 'studentProfile')->middleware('auth'); // profile student
    Route::resource('/student','StudentController');
});
Route::controller(ClassController::class)->group(function () {
    Route::get('classes/list', 'classes')->middleware('auth')->name('classes/list'); // list student
    Route::get('classes/add/page', 'classesAdd')->middleware('auth')->name('classes/add/page'); // page student
    Route::post('classes/add/save', 'classesSave')->name('classes/add/save'); // save record student
    Route::get('classes/edit/{id}', 'classesEdit'); // view for edit
    Route::post('classes/update', 'classesUpdate')->name('classes/update'); // update record student
    Route::post('/classes/delete', 'delete')->name('classes.delete');
    Route::resource('/classes','ClassController');
});
});

