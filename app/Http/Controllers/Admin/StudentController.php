<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Faculty;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $students = User::withTrashed()->latest()->role('mahasiswa');
        if ($request->ajax()) {
            return DataTables::of($students)
                ->addColumn('fakultas', function ($query) {
                    return $query->profil_user->faculty->fakultas;
                })
                ->addColumn('program_studi', function ($query) {
                    return $query->profil_user->program_study->program_studi;
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
                    $btnUbah = '<a href="' . route('students.show', ['student' => $query->id]) . '" class="btn btn-primary btn-sm">Detail</a>';
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
        $faculties = Faculty::get();
        return view('admin.student-create', compact('faculties'));
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
            'program_study_id' => 'required',
            'name' => 'required',
            'nim' => 'required|unique:users',
            'email' => 'required',
            'password' => 'required'
        ]);

        User::withoutEvents(function () use ($request, $forms) {
            $forms['name'] =  Str::title($request->name);
            $forms['email'] = Str::lower($request->email);
            $forms['password'] = Hash::make($request->password);
            $user = User::create($forms);

            $user->profil_user()->create([
                'faculty_id' => $request->faculty_id,
                'program_study_id' => $request->program_study_id,
            ]);

            $user->assignRole('mahasiswa');
        });

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
        return view('admin.student-show', compact('student'));
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

        return back()->with('status', 'Data berhasil diaktifkan!');
    }
}
