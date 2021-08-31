@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <a href="{{ route('students.index') }}" class="btn btn-primary mb-2">Lihat Data</a>
                <div class="card">
                    <div class="card-header">{{ __('Tambah Data Mahasiswa') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{ route('students.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Fakultas</label>
                                <select class="form-control @error('faculty_id') is-invalid @enderror" name="faculty_id">
                                    <option value="" selected disabled>Pilih</option>
                                    @foreach ($faculties as $faculty)
                                        <option value="{{ $faculty->id }}"
                                            {{ old('faculty_id') == $faculty->id ? 'selected' : '' }}>
                                            {{ $faculty->fakultas }}</option>
                                    @endforeach
                                </select>
                                <x-validation-single field="faculty_id"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>Program Studi</label>
                                <select class="form-control @error('program_study_id') is-invalid @enderror"
                                    name="program_study_id">
                                    <option value="" selected disabled>Pilih</option>
                                </select>
                                <x-validation-single field="program_study_id"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>Nama Mahasiswa</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}">
                                <x-validation-single field="name"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>NIM</label>
                                <input type="number" name="nim" class="form-control @error('nim') is-invalid @enderror"
                                    value="{{ old('nim') }}">
                                <x-validation-single field="nim"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}">
                                <x-validation-single field="email"></x-validation-single>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror">
                                <x-validation-single field="password"></x-validation-single>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(function() {
            $('[name="faculty_id"]').on('change', function(e) {
                let id = $(this).val();
                $.ajax({
                    url: "{{ route('students.show-ajax') }}",
                    type: 'POST',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        let data = '<option value="" selected disabled>Pilih</option>';
                        $.each(response.data, (key, value) => {
                            data +=
                                `<option value="${value.id}">${value.program_studi}</option>`;
                        })
                        $('[name="program_study_id"]').html(data);
                    }
                });
            })
        });
    </script>
@endpush
