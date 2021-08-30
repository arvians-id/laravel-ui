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

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($query) {
            $query->fakultas = Str::title($query->fakultas);
        });
        static::deleted(function ($query) {
            $query->program_study()->delete();
        });
    }
    public function program_study()
    {
        return $this->hasMany(ProgramStudy::class);
    }
}
