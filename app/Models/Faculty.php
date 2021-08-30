<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Faculty extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['fakultas'];

    public function program_study()
    {
        return $this->hasMany(ProgramStudy::class);
    }
    public function profil_user()
    {
        return $this->hasMany(ProfileUser::class);
    }
}
