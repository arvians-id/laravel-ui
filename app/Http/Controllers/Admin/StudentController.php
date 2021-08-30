<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $students = User::withTrashed()->latest();
        if ($request->ajax()) {
            return DataTables::of($students)
                ->addColumn('fakultas', function ($query) {
                    return $query->profil_user->faculty->fakultas;
                })
                ->addColumn('program_studi', function ($query) {
                    return $query->profil_user->program_study_id;
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
                    $btnUbah = '<a href="' . route('students.edit', ['student' => $query->id]) . '" class="btn btn-warning btn-sm">Ubah</a>';
                    $btn = ($query->trashed() ? null : $btnUbah) . '<form action="' . route($query->trashed() ? 'students.restore' : 'students.destroy', ['student' => $query->id]) . '" class="d-inline" method="POST">
                            ' . method_field('DELETE') . csrf_field() . '
                                <button class="btn btn-danger btn-sm">' . ($query->trashed() ? "Aktifkan" : "Nonaktifkan") . '</button>
                            </form>';

                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }
        return view('admin.student', compact($students));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programStudies = ProgramStudy::get();
        return view('admin.student-create', compact('programStudies'));
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
            'kode_matkul' => 'required|unique:students',
            'mata_kuliah' => 'required|unique:students',
            'sks' => 'required|numeric',
            'dosen_pengampu' => 'required',
        ]);

        User::create($forms);
        return redirect()->route('students.index')->with('status', 'Data berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $student
     * @return \Illuminate\Http\Response
     */
    public function show(User $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(User $student)
    {
        $programStudies = ProgramStudy::get();
        return view('admin.student-create', compact('student', 'programStudies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $student)
    {
        $forms = $request->validate([
            'program_study_id' => 'required',
            'kode_matkul' => 'required|unique:students,kode_matkul,' . $student->id,
            'mata_kuliah' => 'required|unique:students,mata_kuliah,' . $student->id,
            'sks' => 'required|numeric',
            'dosen_pengampu' => 'required',
            'fakultas' => 'required|unique:students'
        ]);

        User::findOrFail($student->id)->update($forms);
        return redirect()->route('faculties.index')->with('status', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $student)
    {
        User::findOrFail($student->id)->delete();

        return back()->with('status', 'Data berhasil dinonaktifkan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $student
     * @return \Illuminate\Http\Response
     */
    public function restore($student)
    {
        User::where('id', $student)->restore();

        // ProgramStudy::where('student_id', $student)->restore();

        return back()->with('status', 'Data berhasil diaktifkan!');
    }
}
