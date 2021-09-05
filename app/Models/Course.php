<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['program_study_id', 'kode_matkul', 'mata_kuliah', 'semester', 'sks', 'dosen_pengampu'];

    // Logic
    public function getKodeMatkulAttribute($value)
    {
        return 'MK' . str_pad($value, 5, '0', STR_PAD_LEFT);
    }
    // Relation
    public function program_study()
    {
        return $this->belongsTo(ProgramStudy::class)->withTrashed();
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['school_year_id']);
    }
    public function school_years()
    {
        return $this->belongsToMany(SchoolYear::class);
    }
}
