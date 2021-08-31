@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Detail Mahasiswa ') . $student->nim }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-6">
                                <p>Nama : {{ $student->name }}</p>
                                <p>NIM : {{ $student->nim }}</p>
                                <p>Email : {{ $student->email }}</p>
                                <p>Status : {{ $student->email_verified_at ? 'Sudah Verif' : 'Belum Verif' }}</p>
                                <p>Tanggal Lahir : {{ $student->tanggal_lahir }}</p>
                            </div>
                            <div class="col-6">
                                <p>Fakultas : {{ $student->profil_user->faculty->fakultas }}</p>
                                <p>Program Studi : {{ $student->profil_user->program_study->program_studi }}</p>
                                <p>Jenis Kelamin : {{ $student->jenis_kelamin }}</p>
                                <p>No Handphone : {{ $student->no_hp }}</p>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
