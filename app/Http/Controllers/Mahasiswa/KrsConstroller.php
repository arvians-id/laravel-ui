<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use App\Models\User;
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
        // Ambil Data Mata Kuliah Sesuai Program Studi
        $courses = Course::where('program_study_id', Auth::user()->profil_user->program_study_id)->latest()->get();

        // Cek TA & Semester
        $school_years = SchoolYear::with('users')->first();
        // Cek Setujui
        $school_year_user = $school_years->users()->where('user_id', Auth::id())->first();

        // Ambil Data Mata Kuliah User
        $course_users = Course::whereHas('users', function ($query) {
            $query->where('user_id', Auth::id())->where('school_year_id', SchoolYear::first()->id);
        })->get();

        return view('mahasiswa.krs', compact('courses', 'course_users', 'school_years', 'school_year_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $course = Course::with('users')->findOrFail($request->course_id);
        $this->authorize('create', $course);

        $course->users()->attach([Auth::id() => ['school_year_id' => SchoolYear::first()->id]]);
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
        $user = User::findOrFail(Auth::id());
        $this->authorize('destroy', $user);

        $krs = Course::findOrFail($id);
        $krs->users()->wherePivot('user_id', Auth::id())->wherePivot('school_year_id', SchoolYear::first()->id)->detach();
        return back()->with('status', 'Data berhasil dihapus');
    }
}
