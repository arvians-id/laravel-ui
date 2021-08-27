<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileUser extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['user_id', 'tanggal_lahir', 'faculty_id', 'program_study_id', 'jenis_kelamin', 'no_hp', 'photo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
