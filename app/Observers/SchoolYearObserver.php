<?php

namespace App\Observers;

use App\Models\SchoolYear;

class SchoolYearObserver
{
    /**
     * Handle the SchoolYear "saved" event.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return void
     */
    public function saved(SchoolYear $schoolYear)
    {
        $schoolYear->delete();
    }
}
