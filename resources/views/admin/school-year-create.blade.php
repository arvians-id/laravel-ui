@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <a href="{{ route('school-years.index') }}" class="btn btn-primary mb-2">Lihat Data</a>
                <div class="card">
                    <div class="card-header">{{ __('Tambah Tahun Ajaran') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form
                            action="{{ isset($schoolYear) ? route('school-years.update', ['program_study' => $schoolYear->id]) : route('school-years.store') }}"
                            method="POST">
                            @isset($schoolYear) @method('PUT') @endisset
                            @csrf
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <input type="number" name="tahun_ajaran"
                                    class="form-control @error('tahun_ajaran') is-invalid @enderror"
                                    value="{{ old('tahun_ajaran', isset($schoolYear) ? $schoolYear->tahun_ajaran : '') }}">
                                <x-validation-single field="tahun_ajaran"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>Semester</label>
                                <input type="number" name="semester"
                                    class="form-control @error('semester') is-invalid @enderror"
                                    value="{{ old('semester', isset($schoolYear) ? $schoolYear->semester : '') }}">
                                <x-validation-single field="semester"></x-validation-single>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
