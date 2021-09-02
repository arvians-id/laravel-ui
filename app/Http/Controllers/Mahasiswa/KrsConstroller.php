<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\User;
use App\Models\Course;
use App\Models\ProfileUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class KrsConstroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $program_studi = ProfileUser::where('program_study_id', Auth::user()->profil_user->program_study_id)->first();
        $courses = Course::where('program_study_id', $program_studi->program_study_id)->latest()->get();

        $course_users = Course::whereHas('course_user', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();
        return view('mahasiswa.krs', compact('courses', 'course_users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $krs = Course::findOrFail($request->course_id);
        $krs->course_user()->sync(['user_id' => Auth::id()]);
        return back()->with('status', 'Data berhasil ditambahkan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $krs = Course::findOrFail($id);
        $krs->course_user()->detach();
        return back()->with('status', 'Data berhasil dihapus');
    }
}
