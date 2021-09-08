<?php

namespace App\Providers;

use App\Models\{User, Course, Faculty, ProgramStudy};
use App\Observers\{UserObserver, CourseObserver, FacultyObserver, ProgramStudyObserver};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Faculty::observe(FacultyObserver::class);
        ProgramStudy::observe(ProgramStudyObserver::class);
        User::observe(UserObserver::class);
        Course::observe(CourseObserver::class);
    }
}
