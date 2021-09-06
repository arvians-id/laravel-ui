@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Profil Mahasiswa ') . $student->nim }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row d-flex align-items-center">
                            <div class="col-4">
                                <img src="/storage/images/{{ $student->profile_user->photo }}" class="img-fluid">
                            </div>
                            <div class="col-4">
                                <p>Nama : {{ $student->name }}</p>
                                <p>NIM : {{ $student->nim }}</p>
                                <p>Email : {{ $student->email }}</p>
                                <p>Status : {{ $student->email_verified }}</p>
                                <p>Tanggal Lahir : {{ $student->profile_user->tanggal_lahir }}</p>
                            </div>
                            <div class="col-4">
                                <p>Fakultas : {{ $student->profile_user->faculty->fakultas }}</p>
                                <p>Program Studi : {{ $student->profile_user->program_study->program_studi }}</p>
                                <p>Jenis Kelamin : {{ $student->profile_user->jenis_kelamin }}</p>
                                <p>No Handphone : {{ $student->profile_user->no_hp }}</p>
                            </div>
                        </div>
                        <hr>
                        <form method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $student->email) }}">
                                <x-validation-single field="email"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    value="{{ old('tanggal_lahir', $student->profile_user->tanggal_lahir) }}">
                                <x-validation-single field="tanggal_lahir"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select name="jenis_kelamin"
                                    class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                    <option value="" disabled selected>Pilih</option>
                                    <option value="Laki-laki"
                                        {{ $student->profile_user->jenis_kelamin == 'Laki-laki' ? 'selected' : null }}
                                        {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : null }}>Laki-laki
                                    </option>
                                    <option value="Perempuan"
                                        {{ $student->profile_user->jenis_kelamin == 'Perempuan' ? 'selected' : null }}
                                        {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : null }}>Perempuan
                                    </option>
                                </select>
                                <x-validation-single field="jenis_kelamin"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>No Handphone</label>
                                <input type="number" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                                    value="{{ old('no_hp', $student->profile_user->no_hp) }}">
                                <x-validation-single field="no_hp"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>Photo</label>
                                <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                                <x-validation-single field="photo"></x-validation-single>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
