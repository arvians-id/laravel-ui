<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgramStudy extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['faculty'];
    public $fillable = ['faculty_id', 'program_studi'];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class)->withTrashed();
    }
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
    public function profil_users()
    {
        return $this->hasMany(ProfileUser::class);
    }
}
