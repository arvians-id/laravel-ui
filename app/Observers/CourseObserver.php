<?php

namespace App\Observers;

use App\Models\Course;
use Illuminate\Support\Str;

class CourseObserver
{
    /**
     * Handle the Course "creating" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function creating(Course $course)
    {
        $inc = Course::max('kode_matkul') + 1;
        $course->kode_matkul = $inc;
        $course->mata_kuliah = Str::title($course->mata_kuliah);
        $course->dosen_pengampu = Str::title($course->dosen_pengampu);
    }
    /**
     * Handle the Course "updating" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function updating(Course $course)
    {
        $course->mata_kuliah = Str::title($course->mata_kuliah);
        $course->dosen_pengampu = Str::title($course->dosen_pengampu);
    }
}
