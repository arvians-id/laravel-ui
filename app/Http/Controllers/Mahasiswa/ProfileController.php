<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if ($request->post()) {
            $forms = $request->validate([
                'email' => 'required|email',
                'tanggal_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'no_hp' => 'required|numeric|digits_between:9,13',
                'photo' => 'mimes:jpg,png,jpeg|max:1080'
            ]);
            $user = User::where('id', Auth::id())->firstOrFail();
            $user->update(['email' => $request->email]);

            $file = $request->file('photo');
            $photo = null;

            if ($request->hasFile('photo')) {
                $namePhoto = Str::uuid() . '.' . $file->extension();
                $file->move(public_path('storage/images'), $namePhoto);
                $photo = $namePhoto;

                $path = public_path('storage/images/') . Auth::user()->profile_user->photo;
                if (File::exists($path) && Auth::user()->profile_user->photo != 'default.png') {
                    File::delete($path);
                }
            }

            $user->profile_user()->update([
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'photo' => $photo ?: Auth::user()->profile_user->photo,
            ]);

            return back()->with('status', 'Data berhasil diubah');
        }
        $student = User::with(['profile_user.faculty', 'profile_user.program_study'])->where('id', Auth::id())->firstOrFail();
        return view('mahasiswa.profile', compact('student'));
    }
}
