<?php

use App\Models\SchoolYear;
use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\Mahasiswa\KrsConstroller;
use App\Http\Controllers\Mahasiswa\ProfileController;
use App\Http\Controllers\Admin\{DashboardController, CourseController, FacultyController, ProgramStudyController, SchoolYearController, StudentController};

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
        Route::post('/students/show-studies', function (Request $request) {
            echo json_encode(['data' => ProgramStudy::where('faculty_id', $request->id)->get()]);
        })->name('students.show-ajax');
        Route::delete('/students/restore/{student}', [StudentController::class, 'restore'])->name('students.restore');
        Route::resource('students', StudentController::class)->except(['edit', 'update']);

        Route::delete('/faculties/restore/{faculty}', [FacultyController::class, 'restore'])->name('faculties.restore');
        Route::resource('faculties', FacultyController::class)->except(['show']);

        Route::delete('/program-studies/restore/{program_study}', [ProgramStudyController::class, 'restore'])->name('program-studies.restore');
        Route::resource('program-studies', ProgramStudyController::class)->except(['show']);

        Route::post('/school-years/setujui/{school_year}/{user}', [SchoolYearController::class, 'setujui'])->name('school-years.setujui');
        Route::delete('/school-years/restore/{school_year}', [SchoolYearController::class, 'restore'])->name('school-years.restore');
        Route::resource('school-years', SchoolYearController::class);

        Route::delete('/courses/restore/{course}', [CourseController::class, 'restore'])->name('courses.restore');
        Route::resource('courses', CourseController::class)->except(['show']);;
    });

    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::match(['get', 'post'], '/profile', ProfileController::class)->name('profile');
        Route::resource('study-plan-cards', KrsConstroller::class)->except(['create', 'show', 'update', 'edit']);
    });

    Route::get('/media/{filename}', function ($filename) {
        $path = 'images/' . $filename;
        if (!Storage::exists($path)) {
            abort(404);
        }

        return Storage::response($path);
    });
});
