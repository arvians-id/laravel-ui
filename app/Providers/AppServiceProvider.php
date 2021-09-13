<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Models\{User, Course, Faculty, ProgramStudy};
use App\Observers\{UserObserver, CourseObserver, FacultyObserver, ProgramStudyObserver};

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

        Model::preventLazyLoading(!app()->isProduction());
    }
}
