<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\SchoolYear;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can create the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Course $course)
    {
        return !$user->courses()->where('course_id', $course->id)->where('school_year_id', SchoolYear::first()->id)->exists();
    }
}
