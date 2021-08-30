<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $faculties = Faculty::withTrashed()->latest();
        if ($request->ajax()) {
            return DataTables::of($faculties)
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
                    $btn = '<a href="' . route('faculties.edit', ['faculty' => $query->id]) . '" class="btn btn-warning btn-sm">Ubah</a>
                            <form action="' . route($query->trashed() ? 'faculties.restore' : 'faculties.destroy', ['faculty' => $query->id]) . '" class="d-inline" method="POST">
                            ' . method_field('DELETE') . csrf_field() . '
                                <button class="btn btn-danger btn-sm">' . ($query->trashed() ? "Aktifkan" : "Nonaktifkan") . '</button>
                            </form>';

                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }
        return view('admin.faculty', compact($faculties));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.faculty-create');
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
            'fakultas' => 'required|unique:faculties'
        ]);

        Faculty::create($forms);
        return redirect()->route('faculties.index')->with('status', 'Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function edit(Faculty $faculty)
    {
        return view('admin.faculty-create', compact('faculty'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faculty $faculty)
    {
        $forms = $request->validate([
            'fakultas' => 'required|unique:faculties,fakultas,' . $faculty->id
        ]);

        Faculty::findOrFail($faculty->id)->update($forms);
        return redirect()->route('faculties.index')->with('status', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faculty $faculty)
    {
        Faculty::findOrFail($faculty->id)->delete();

        return back()->with('status', 'Data berhasil dinonaktifkan!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faculty  $faculty
     * @return \Illuminate\Http\Response
     */
    public function restore($faculty)
    {
        Faculty::where('id', $faculty)->restore();

        ProgramStudy::where('faculty_id', $faculty)->restore();

        return back()->with('status', 'Data berhasil diaktifkan!');
    }
}
