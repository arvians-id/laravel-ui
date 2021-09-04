<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolYear extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['tahun_ajaran', 'semester', 'is_active'];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
    public function school_year_user()
    {
        return $this->belongsToMany(User::class)->withPivot('disetujui');
    }
}
