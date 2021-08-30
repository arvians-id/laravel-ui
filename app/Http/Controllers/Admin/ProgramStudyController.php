<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Faculty;

class ProgramStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $programStudies = ProgramStudy::withTrashed()->latest();
        if ($request->ajax()) {
            return DataTables::of($programStudies)
                ->addColumn('fakultas', function ($query) {
                    return $query->faculty->fakultas;
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
                    $btn = '<a href="' . route('program-studies.edit', ['program_study' => $query->id]) . '" class="btn btn-warning btn-sm">Ubah</a>
                            <form action="' . route($query->trashed() ? 'program-studies.restore' : 'program-studies.destroy', ['program_study' => $query->id]) . '" class="d-inline" method="POST">
                            ' . method_field('DELETE') . csrf_field() . '
                                <button class="btn btn-danger btn-sm">' . ($query->trashed() ? "Aktifkan" : "Nonaktifkan") . '</button>
                            </form>';

                    return $query->faculty->trashed() ? 'Fakultas dinonaktifkan' : $btn;
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }
        return view('admin.program-study', compact($programStudies));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faculties = Faculty::get();
        return view('admin.program-study-create', compact('faculties'));
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
            'faculty_id' => 'required',
            'program_studi' => 'required|unique:program_studies'
        ]);

        ProgramStudy::create($forms);
        return redirect()->route('program-studies.index')->with('status', 'Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProgramStudy  $programStudy
     * @return \Illuminate\Http\Response
     */
    public function edit(ProgramStudy $programStudy)
    {
        $faculties = Faculty::get();
        return view('admin.program-study-create', compact('programStudy', 'faculties'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProgramStudy  $programStudy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProgramStudy $programStudy)
    {
        $forms = $request->validate([
            'faculty_id' => 'required',
            'program_studi' => 'required|unique:program_studies,program_studi,' . $programStudy->id
        ]);

        ProgramStudy::findOrFail($programStudy->id)->update($forms);
        return redirect()->route('program-studies.index')->with('status', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgramStudy  $programStudy
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProgramStudy $programStudy)
    {
        ProgramStudy::findOrFail($programStudy->id)->delete();

        return back()->with('status', 'Data berhasil dinonaktifkan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProgramStudy  $programStudy
     * @return \Illuminate\Http\Response
     */
    public function restore($programStudy)
    {
        ProgramStudy::where('id', $programStudy)->restore();

        return back()->with('status', 'Data berhasil diaktifkan!');
    }
}
