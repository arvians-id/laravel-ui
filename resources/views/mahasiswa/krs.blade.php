@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($school_years)
            <p>Tahun Ajaran {{ $school_years->tahun_ajaran ?? null }}, Semester
                {{ $school_years->semester ?? null }}
            @else
                <small class="text-danger">Tahun Ajaran Tidak Ditemukan!</small>
        @endif
        </p>
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
                                            @can('destroy', $course_user)
                                                <form
                                                    action="{{ route('study-plan-cards.destroy', ['study_plan_card' => $course_user->id]) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-danger btn-sm">-</button>
                                                </form>
                                            @endcan
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
                        {!! isset($school_year_user) ? ($school_year_user->pivot->disetujui ? 'KRS Disetujui <i class="far fa-check-circle text-success"></i>' : 'KRS Belum Disetujui <i class="far fa-times-circle text-danger"></i>') : null !!}
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
                                            @can('create', $course)
                                                <form action="{{ route('study-plan-cards.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                    <button class="btn btn-success btn-sm">+</button>
                                                </form>
                                            @endcan
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
@push('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
@endpush
