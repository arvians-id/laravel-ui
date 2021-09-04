<?php

namespace App\Models;

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
        return $this->belongsTo(ProgramStudy::class)->withDefault(['program_studi' => 'Tidak Ditemukan']);
    }
    public function getKodeMatkulAttribute($value)
    {
        return 'MK' . str_pad($value, 5, '0', STR_PAD_LEFT);
    }
    public function course_user()
    {
        return $this->belongsToMany(User::class)->withPivot(['school_year_id']);
    }
    public function school_user()
    {
        return $this->belongsToMany(SchoolYear::class);
    }
}
