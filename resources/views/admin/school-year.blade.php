@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <a href="{{ route('school-years.create') }}" class="btn btn-primary mb-2">Tambah</a>
                <div class="card">
                    <div class="card-header">{{ __('Data Tahun Ajaran') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table id="myTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tahun Ajaran</th>
                                    <th>Semester</th>
                                    <th>Dibuat</th>
                                    <th>Terakhir diubah</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
@endpush
@push('js')
    <script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(function() {
            $('#myTable').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('school-years.index') }}",
                    type: 'GET'
                },
                columns: [{
                    data: 'tahun_ajaran'
                }, {
                    data: 'semester'
                }, {
                    data: 'created_at'
                }, {
                    data: 'updated_at'
                }, {
                    data: 'deleted_at'
                }, {
                    data: 'aksi'
                }]
            });
        });
    </script>
@endpush
