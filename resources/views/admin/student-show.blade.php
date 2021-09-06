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
                                <p>Status : {{ $student->email_verified }}</p>
                                <p>Tanggal Lahir : {{ $student->profile_user->tanggal_lahir }}</p>
                            </div>
                            <div class="col-6">
                                <p>Fakultas : {{ $student->profile_user->faculty->fakultas }}</p>
                                <p>Program Studi : {{ $student->profile_user->program_study->program_studi }}</p>
                                <p>Jenis Kelamin : {{ $student->profile_user->jenis_kelamin }}</p>
                                <p>No Handphone : {{ $student->profile_user->no_hp }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
