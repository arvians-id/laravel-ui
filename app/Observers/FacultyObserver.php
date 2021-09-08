<?php

namespace App\Observers;

use App\Models\Faculty;
use Illuminate\Support\Str;

class FacultyObserver
{
    /**
     * Handle the Faculty "saving" event.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return void
     */
    public function saving(Faculty $faculty)
    {
        $faculty->fakultas = Str::title($faculty->fakultas);
    }
}
