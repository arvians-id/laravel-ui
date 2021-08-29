@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <a href="{{ route('program-studies.index') }}" class="btn btn-primary mb-2">Lihat Data</a>
                <div class="card">
                    <div class="card-header">{{ __('Tambah Program Studi') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form
                            action="{{ isset($programStudy) ? route('program-studies.update', ['program_study' => $programStudy->id]) : route('program-studies.store') }}"
                            method="POST">
                            @isset($programStudy) @method('PUT') @endisset
                            @csrf
                            <div class="form-group">
                                <label>Fakultas</label>
                                <select class="form-control @error('faculty_id') is-invalid @enderror" name="faculty_id">
                                    <option value="" selected disabled>Pilih</option>
                                    @foreach ($faculties as $faculty)
                                        <option value="{{ $faculty->id }}"
                                            {{ isset($programStudy) ? ($programStudy->faculty_id == $faculty->id ? 'selected' : '') : '' }}>
                                            {{ $faculty->fakultas }}</option>
                                    @endforeach
                                </select>
                                <x-validation-single field="faculty_id"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>Program Studi</label>
                                <input type="text" name="program_studi"
                                    class="form-control @error('program_studi') is-invalid @enderror"
                                    value="{{ old('program_studi', isset($programStudy) ? $programStudy->program_studi : '') }}">
                                <x-validation-single field="program_studi"></x-validation-single>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
