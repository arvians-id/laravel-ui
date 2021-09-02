@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 mb-2">
                <div class="card">
                    <div class="card-header">{{ __('Daftar Kontrak ') }}</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Semester</th>
                                    <th>Kode MK</th>
                                    <th>Mata Kuliah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($course_users as $course_user)
                                    <tr>
                                        <td>
                                            <form
                                                action="{{ route('study-plan-mahasiswa.destroy', ['study_plan_mahasiswa' => $course_user->id]) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger btn-sm">-</button>
                                            </form>
                                        </td>
                                        <td class="text-center">{{ $course_user->semester }}</td>
                                        <td>{{ $course_user->kode_matkul }}</td>
                                        <td>{{ $course_user->mata_kuliah }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Tidak ada data ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Mata Kuliah yang Tersedia') }}</div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Semester</th>
                                    <th>Kode MK</th>
                                    <th>Mata Kuliah</th>
                                    <th>SKS</th>
                                    <th>Dosen Pengampu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($courses as $course)
                                    <tr>
                                        <td>
                                            <form action="{{ route('study-plan-mahasiswa.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                <button class="btn btn-success btn-sm">+</button>
                                            </form>
                                        </td>
                                        <td class="text-center">{{ $course->semester }}</td>
                                        <td>{{ $course->kode_matkul }}</td>
                                        <td>{{ $course->mata_kuliah }}</td>
                                        <td>{{ $course->sks }}</td>
                                        <td>{{ $course->dosen_pengampu }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Tidak ada data ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
