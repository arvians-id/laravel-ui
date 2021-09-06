<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['fakultas'];

    public function program_studies()
    {
        return $this->hasMany(ProgramStudy::class);
    }
    public function profile_users()
    {
        return $this->hasMany(ProfileUser::class);
    }
}
