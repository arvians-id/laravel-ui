<?php

use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{DashboardController, CourseController, FacultyController, KrsController, ProgramStudyController, SchoolYearController, StudentController};

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
            if ($request->ajax()) {
                $programStudies['data'] = ProgramStudy::where('faculty_id', $request->id)->get();

                echo json_encode($programStudies);
            }
        })->name('students.show-ajax');

        Route::delete('/students/restore/{student}', [StudentController::class, 'restore'])->name('students.restore');
        Route::resource('students', StudentController::class)->except(['edit', 'update']);
        Route::delete('/faculties/restore/{faculty}', [FacultyController::class, 'restore'])->name('faculties.restore');
        Route::resource('faculties', FacultyController::class)->except(['show']);
        Route::delete('/program-studies/restore/{program_study}', [ProgramStudyController::class, 'restore'])->name('program-studies.restore');
        Route::resource('program-studies', ProgramStudyController::class)->except(['show']);
        Route::delete('/school-years/restore/{school_year}', [SchoolYearController::class, 'restore'])->name('school-years.restore');
        Route::resource('school-years', SchoolYearController::class)->except(['show']);
        Route::delete('/courses/restore/{course}', [CourseController::class, 'restore'])->name('courses.restore');
        Route::resource('courses', CourseController::class)->except(['show']);;
        Route::resource('study-plan-cards', KrsController::class);
    });

    Route::middleware(['role:mahasiswa'])->group(function () {
        Route::get('/mahasiswa', fn () => 'asu')->name('mahasiswa');
    });
});
