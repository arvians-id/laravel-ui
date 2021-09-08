<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\User;
use App\Traits\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use FileUpload;
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


            DB::beginTransaction();
            try {
                $user = User::where('id', Auth::id())->firstOrFail();
                $user->update(['email' => $request->email]);

                $user->profile_user()->update([
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'no_hp' => $request->no_hp,
                    'photo' => $this->withDelete() ?: Auth::user()->profile_user->photo,
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

            return back()->with('status', 'Data berhasil diubah');
        }
        $student = User::with(['profile_user.faculty', 'profile_user.program_study'])->where('id', Auth::id())->firstOrFail();
        return view('mahasiswa.profile', compact('student'));
    }
}
