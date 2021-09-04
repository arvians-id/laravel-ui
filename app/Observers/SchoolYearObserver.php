<?php

namespace App\Observers;

use App\Models\SchoolYear;

class SchoolYearObserver
{
    /**
     * Handle the SchoolYear "created" event.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return void
     */
    public function created(SchoolYear $schoolYear)
    {
        $schoolYear->delete();
    }
}
