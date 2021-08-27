<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'nim' => '1010101010',
            'name' => 'Admin',
            'email' => 'admin@widdyarfian.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('Rahasia123'),
        ]);

        $user->assignRole('administrator');

        $user->profil_user()->create();
    }
}
