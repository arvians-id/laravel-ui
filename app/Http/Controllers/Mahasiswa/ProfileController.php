<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\User;
use App\Traits\FilePond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use FilePond;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $student = User::with(['profile_user.faculty', 'profile_user.program_study'])->where('id', Auth::id())->firstOrFail();
        return view('mahasiswa.profile', compact('student'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'mimes:jpg,png|max:500'
        ]);
        if ($request->hasFile('photo')) {
            $this->process('update-profile');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required|numeric|digits_between:9,13',
        ]);

        DB::beginTransaction();
        try {
            $user = User::where('id', Auth::id())->firstOrFail();
            $user->update(['email' => $request->email]);
            $user->profile_user()->update([
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'no_hp' => $request->no_hp,
                'photo' => $this->moveFileFromTemp('update-profile'),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return back()->with('status', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $profile)
    {
        $this->revert('update-profile');
    }
}
