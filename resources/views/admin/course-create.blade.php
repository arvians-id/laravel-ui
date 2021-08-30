@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <a href="{{ route('courses.index') }}" class="btn btn-primary mb-2">Lihat Data</a>
                <div class="card">
                    <div class="card-header">{{ __('Tambah Data Mata Kuliah') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form
                            action="{{ isset($course) ? route('courses.update', ['course' => $course->id]) : route('courses.store') }}"
                            method="POST">
                            @isset($course) @method('PUT') @endisset
                            @csrf
                            <div class="form-group">
                                <label>Program Studi</label>
                                <select class="form-control @error('program_study_id') is-invalid @enderror"
                                    name="program_study_id">
                                    <option value="" selected disabled>Pilih</option>
                                    @foreach ($programStudies as $programStudy)
                                        <option value="{{ $programStudy->id }}"
                                            {{ isset($course) ? ($programStudy->id == $course->program_study_id ? 'selected' : '') : '' }}
                                            {{ old('program_study_id') == $programStudy->id ? 'selected' : '' }}>
                                            {{ $programStudy->program_studi }}</option>
                                    @endforeach
                                </select>
                                <x-validation-single field="program_study_id"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>Kode Mata Kuliah</label>
                                <input type="text" name="kode_matkul"
                                    class="form-control @error('kode_matkul') is-invalid @enderror"
                                    value="{{ old('kode_matkul', isset($course) ? $course->kode_matkul : '') }}">
                                <x-validation-single field="kode_matkul"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>Mata Kuliah</label>
                                <input type="text" name="mata_kuliah"
                                    class="form-control @error('mata_kuliah') is-invalid @enderror"
                                    value="{{ old('mata_kuliah', isset($course) ? $course->mata_kuliah : '') }}">
                                <x-validation-single field="mata_kuliah"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>SKS</label>
                                <input type="number" name="sks" class="form-control @error('sks') is-invalid @enderror"
                                    value="{{ old('sks', isset($course) ? $course->sks : '') }}">
                                <x-validation-single field="sks"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>Dosen Pengampu</label>
                                <input type="text" name="dosen_pengampu"
                                    class="form-control @error('dosen_pengampu') is-invalid @enderror"
                                    value="{{ old('dosen_pengampu', isset($course) ? $course->dosen_pengampu : '') }}">
                                <x-validation-single field="dosen_pengampu"></x-validation-single>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
