<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Faculty;
use App\Models\SchoolYear;
use App\Models\ProgramStudy;
use App\Observers\UserObserver;
use App\Observers\FacultyObserver;
use App\Observers\SchoolYearObserver;
use App\Observers\ProgramStudyObserver;
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
        SchoolYear::observe(SchoolYearObserver::class);
        User::observe(UserObserver::class);
    }
}
