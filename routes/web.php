<?php

use App\Http\Controllers\Admin\{DashboardController, CourseController, FacultyController, KrsController, MahasiswaController, ProgramStudyController, SchoolYearController};
use App\Models\ProgramStudy;
use App\Models\SchoolYear;
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
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::middleware(['role:administrator'])->group(function () {

        Route::resource('students', MahasiswaController::class);
        Route::delete('/faculties/restore/{faculty}', [FacultyController::class, 'restore'])->name('faculties.restore');
        Route::resource('faculties', FacultyController::class)->except(['show']);
        Route::delete('/program-studies/restore/{program_study}', [ProgramStudyController::class, 'restore'])->name('program-studies.restore');
        Route::resource('program-studies', ProgramStudyController::class)->except(['show']);;
        Route::delete('/school-years/restore/{school_year}', [SchoolYearController::class, 'restore'])->name('school-years.restore');
        Route::resource('school-years', SchoolYearController::class)->except(['show']);;
        Route::resource('courses', CourseController::class);
        Route::resource('study-plan-cards', KrsController::class);
    });

    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/mahasiswa', fn () => 'asu')->name('mahasiswa');
    });
});
