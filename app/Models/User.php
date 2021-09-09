<?php

namespace App\Models;

use App\Notifications\SendResetPassword;
use App\Notifications\SendVerificationUserRegistration;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'nim',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Logic
    public function getEmailVerifiedAttribute()
    {
        return $this->email_verified_at ? 'Sudah Verif' : 'Belum Verif';
    }
    // Relation
    public function profile_user()
    {
        return $this->hasOne(ProfileUser::class);
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
    public function school_years()
    {
        return $this->belongsToMany(SchoolYear::class)->withPivot('disetujui');
    }
    // Overide
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new SendResetPassword($token));
    }
    public function sendEmailVerificationNotification()
    {
        $this->notify(new SendVerificationUserRegistration);
    }
}
