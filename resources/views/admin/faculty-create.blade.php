@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <a href="{{ route('faculties.index') }}" class="btn btn-primary mb-2">Lihat Data</a>
                <div class="card">
                    <div class="card-header">{{ __('Tambah Fakultas') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form
                            action="{{ isset($faculty) ? route('faculties.update', ['faculty' => $faculty->id]) : route('faculties.store') }}"
                            method="POST">
                            @isset($faculty) @method('PUT') @endisset
                            @csrf
                            <div class="form-group">
                                <label>Fakultas</label>
                                <input type="text" name="fakultas"
                                    class="form-control @error('fakultas') is-invalid @enderror"
                                    value="{{ old('fakultas', isset($faculty) ? $faculty->fakultas : '') }}">
                                <x-validation-single field="fakultas"></x-validation-single>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
