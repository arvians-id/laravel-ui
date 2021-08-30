<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\ProgramStudy;

class ProgramStudyObserver
{
    /**
     * Handle the ProgramStudy "created" event.
     *
     * @param  \App\Models\ProgramStudy  $programStudy
     * @return void
     */
    public function saving(ProgramStudy $programStudy)
    {
        $programStudy->program_studi = Str::title($programStudy->program_studi);
    }
}
