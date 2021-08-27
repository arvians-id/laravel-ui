<?php

use App\Http\Controllers\Admin\{DashboardController, CourseController, FacultyController, KrsController, MahasiswaController, ProgramStudyController, SchoolYearController};
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


Route::redirect('/', '/login', 301);

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware(['role:administrator'])->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::resource('mahasiswa', MahasiswaController::class);
        Route::resource('fakultas', FacultyController::class);
        Route::resource('program-studi', ProgramStudyController::class);
        Route::resource('tahun-ajaran', SchoolYearController::class);
        Route::resource('mata-kuliah', CourseController::class);
        Route::resource('krs', KrsController::class);
    });

    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/mahasiswa', fn () => 'asu')->name('mahasiswa');
    });
});
