<?php

namespace App\Providers;

use App\Models\{User, Course, Faculty, ProgramStudy, SchoolYear};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });

        Route::bind('course', function ($course) { {
                return Course::withTrashed()->findOrFail($course);
            }
        });
        Route::bind('faculty', function ($faculty) { {
                return Faculty::withTrashed()->findOrFail($faculty);
            }
        });
        Route::bind('program_study', function ($program_study) { {
                return ProgramStudy::withTrashed()->findOrFail($program_study);
            }
        });
        Route::bind('school_year', function ($school_year) { {
                return SchoolYear::withTrashed()->findOrFail($school_year);
            }
        });
        Route::bind('student', function ($student) { {
                return User::withTrashed()->findOrFail($student);
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
