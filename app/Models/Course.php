<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['program_study_id', 'kode_matkul', 'mata_kuliah', 'sks', 'dosen_pengampu'];
    protected $with = ['program_study'];

    public function program_study()
    {
        return $this->belongsTo(ProgramStudy::class);
    }
}
