<?php

namespace App\Observers;

use App\Models\ProfileUser;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $user->nim == '1010101010' ? $user->assignRole('administrator') : $user->assignRole('mahasiswa');

        $user->name = Str::title($user->name);
        $user->email = Str::lower($user->email);

        $user->profil_user()->create();
    }
    /**
     * Handle the User "creating" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        if ($user->nim != '1010101010')
            $user->password = Hash::make($user->password);
    }
}
