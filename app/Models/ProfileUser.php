<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileUser extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['user_id', 'tanggal_lahir', 'faculty_id', 'program_study_id', 'jenis_kelamin', 'no_hp', 'photo'];

    protected $with = ['faculty'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function faculty()
    {
        return $this->belongsTo(Faculty::class)->withDefault(['fakultas' => 'Tidak Ditemukan']);
    }
    public function program_study()
    {
        return $this->belongsTo(ProgramStudy::class)->withDefault(['program_studi' => 'Tidak Ditemukan']);
    }
}
