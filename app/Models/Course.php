<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['program_study_id', 'kode_matkul', 'mata_kuliah', 'semester', 'sks', 'dosen_pengampu'];
    protected $with = ['program_study'];

    public function program_study()
    {
        return $this->belongsTo(ProgramStudy::class);
    }
}
