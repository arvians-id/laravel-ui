<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $schoolYears = SchoolYear::withTrashed()->latest();
        if ($request->ajax()) {
            return DataTables::of($schoolYears)
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
                    $btnUbahDetail = '<a href="' . route('school-years.show', ['school_year' => $query->id]) . '" class="btn btn-primary btn-sm">Detail</a>
                    <a href="' . route('school-years.edit', ['school_year' => $query->id]) . '" class="btn btn-warning btn-sm">Ubah</a>';
                    $btn = ($query->trashed() ? '' : $btnUbahDetail) . '<form action="' . route($query->trashed() ? 'school-years.restore' : 'school-years.destroy', ['school_year' => $query->id]) . '" class="d-inline" method="POST">
                            ' . method_field('DELETE') . csrf_field() . '
                                <button class="btn btn-danger btn-sm">' . ($query->trashed() ? "Aktifkan" : "Nonaktifkan") . '</button>
                            </form>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }
        return view('admin.school-year');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function show(SchoolYear $schoolYear, Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of($schoolYear->users)
                ->addColumn('nama', function ($query) {
                    return $query->name;
                })
                ->addColumn('fakultas', function ($query) {
                    return $query->profile_user->faculty->fakultas;
                })
                ->addColumn('program_studi', function ($query) {
                    return $query->profile_user->program_study->program_studi;
                })
                ->addColumn('aksi', function ($query) {
                    $btn = '<form action="' . route('school-years.setujui', ['school_year' => $query->pivot->school_year_id, 'user' => $query->id]) . '" method="POST">
                            ' . csrf_field() . '
                                <button class="btn btn-success btn-sm">Setujui</button>
                            </form>';

                    return $query->pivot->disetujui == null ? $btn : '<i class="far fa-check-circle text-success"></i>';
                })
                ->rawColumns(['aksi'])
                ->toJson();
        }
        return view('admin.krs');
    }

    /**
     * Setujui the specified resource from storage.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function setujui(SchoolYear $school_year, User $user)
    {
        $school_year->users()->updateExistingPivot($user->id, ['disetujui' => date('Y-m-d h:i:s')]);

        dispatch(new SendEmail($user));

        return back()->with('status', 'Data berhasil disetujui');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $schoolYears = SchoolYear::get();
        return view('admin.school-year-create', compact('schoolYears'));
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
            'tahun_ajaran' => 'required',
            'semester' => 'required|numeric|unique:school_years,semester,NULL,id,tahun_ajaran,' . $request->tahun_ajaran,
        ]);

        DB::beginTransaction();
        try {
            $schoolYear = SchoolYear::create($forms);
            $schoolYear->users()->attach(User::withTrashed()->role('mahasiswa')->get()->pluck('id'));
            $schoolYear->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return redirect()->route('school-years.index')->with('status', 'Data berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolYear $schoolYear)
    {
        return view('admin.school-year-create', compact('schoolYear'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolYear $schoolYear)
    {
        $forms = $request->validate([
            'tahun_ajaran' => 'required',
            'semester' => 'required|numeric|unique:school_years,semester,NULL,id,tahun_ajaran,' . $request->tahun_ajaran,
        ]);

        SchoolYear::findOrFail($schoolYear->id)->update($forms);
        return redirect()->route('school-years.index')->with('status', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolYear $schoolYear)
    {
        SchoolYear::findOrFail($schoolYear->id)->delete();

        return back()->with('status', 'Data berhasil dinonaktifkan!');
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function restore(SchoolYear $schoolYear)
    {
        DB::beginTransaction();
        try {
            SchoolYear::whereNull('deleted_at')->delete();
            SchoolYear::where('id', $schoolYear->id)->restore();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return back()->with('status', 'Data berhasil diaktifkan!');
    }
}
