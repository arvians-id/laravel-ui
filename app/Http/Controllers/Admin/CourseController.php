<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\ProgramStudy;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courses = Course::withTrashed()->latest();
        if ($request->ajax()) {
            return DataTables::of($courses)
                ->addColumn('program_studi', function ($query) {
                    return $query->program_study->program_studi;
                })
                ->addColumn('kode_matkul', function ($query) {
                    return $query->kode_matkul;
                })
                ->addColumn('created_at', function ($query) {
                    return $query->created_at->format('d F Y h:i:s');
                })
                ->addColumn('updated_at', function ($query) {
                    return $query->updated_at->format('d F Y h:i:s');
                })
                ->addColumn('deleted_at', function ($query) {
                    return $query->deleted_at == null ? 'Aktif' : 'Tidak Aktif';
                })
                ->addColumn('aksi', function ($query) {
                    $btnUbah = '<a href="' . route('courses.edit', ['course' => $query->id]) . '" class="btn btn-warning btn-sm">Ubah</a>';
                    $btn = ($query->trashed() ? null : $btnUbah) . '<form action="' . route($query->trashed() ? 'courses.restore' : 'courses.destroy', ['course' => $query->id]) . '" class="d-inline" method="POST">
                            ' . method_field('DELETE') . csrf_field() . '
                                <button class="btn btn-danger btn-sm">' . ($query->trashed() ? "Aktifkan" : "Nonaktifkan") . '</button>
                            </form>';

                    return $query->program_study->trashed() ? 'Program Studi Dinonaktifkan' : $btn;
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }
        return view('admin.course', compact($courses));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programStudies = ProgramStudy::get();
        return view('admin.course-create', compact('programStudies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $forms = $request->validate([
            'program_study_id' => 'required',
            'mata_kuliah' => 'required|unique:courses',
            'semester' => 'required',
            'sks' => 'required|numeric',
            'dosen_pengampu' => 'required',
        ]);

        Course::create($forms);
        return redirect()->route('courses.index')->with('status', 'Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        $programStudies = ProgramStudy::get();
        return view('admin.course-create', compact('course', 'programStudies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $forms = $request->validate([
            'program_study_id' => 'required',
            'mata_kuliah' => 'required|unique:courses,mata_kuliah,' . $course->id,
            'semester' => 'required',
            'sks' => 'required|numeric',
            'dosen_pengampu' => 'required',
        ]);

        Course::findOrFail($course->id)->update($forms);
        return redirect()->route('courses.index')->with('status', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        Course::findOrFail($course->id)->delete();

        return back()->with('status', 'Data berhasil dinonaktifkan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function restore(Course $course)
    {
        Course::where('id', $course->id)->restore();

        return back()->with('status', 'Data berhasil diaktifkan!');
    }
}
