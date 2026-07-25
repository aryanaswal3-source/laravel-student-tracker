<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/my-form', [PersonalController::class, 'form'])->name('form');
Route::post('/form-submit', [PersonalController::class, 'formSubmit'])->name('form-submit');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/welcome-dashboard', [PersonalController::class, 'welcomeDashboard'])->name('welcome-dashboard');

    Route::get('/student-data', [PersonalController::class, 'studentData'])->name('student-data');
    Route::get('/edit/{id}', [PersonalController::class, 'edit'])->name('edit');
    Route::post('/update/{id}', [PersonalController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [PersonalController::class, 'delete'])->name('delete');

    Route::get('/students-dashboard', [PersonalController::class, 'dashboard'])->name('students-dashboard');

    Route::get('/upload-image/{id}', [PersonalController::class, 'uploadImageForm'])->name('upload-image-form');
    Route::post('/upload-image/{id}', [PersonalController::class, 'uploadImage'])->name('upload-image');
    Route::get('/delete-image/{id}', [PersonalController::class, 'deleteImage'])->name('delete-image');

    Route::get('/upload-file/{id}', [PersonalController::class, 'uploadFileForm'])->name('upload-file-form');
    Route::post('/upload-file/{id}', [PersonalController::class, 'uploadFile'])->name('upload-file');
    Route::get('/delete-file/{id}', [PersonalController::class, 'deleteFile'])->name('delete-file');

    Route::get('/attendance', [PersonalController::class, 'attendanceForm'])->name('attendance-form');
    Route::post('/attendance', [PersonalController::class, 'markAttendance'])->name('mark-attendance');

});