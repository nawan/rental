
@extends('layouts.main')

@section('content')
<nav aria-label="breadcrumb" class="navbar navbar-light bg-light mb-4 mt-4" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);">
    <ol class="breadcrumb my-auto p-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home mt-1"></i></a></li>
        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Cetak</a></li>
        <li class="breadcrumb-item active" aria-current="page">Surat Jalan</li>
    </ol>
</nav>

<div class="card mt-10">
    <div class="card-header text-center fw-bold text-uppercase mb-10 bg-dark text-white">
        Cetak Surat Jalan
    </div>
    <div class="card-group bg-light mt-10">
        <div class="card">
            <div class="cad-body text-center mt-5 p-2">
                <table class="table table-bordered table-hover text-center align-middle stripe" id="surat-jalan" style="width:100%;">
                    <thead class="thead thead-light bg-secondary text-white table-bordered">
                        <tr class="align-middle">
                            <th scope="col">No</th>
                            <th scope="col">Mobil</th>
                            <th scope="col">Plat</th>
                            <th scope="col">Pelanggan</th>
                            <th scope="col">Durasi</th>
                            <th scope="col">Total</th>
                            <th scope="col">Tujuan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" class="text-center">
                                Data Tidak Ditemukan
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- bootstrap@5.3.0-alpha3 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/bootstrap.min.css') }}" />
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" /> --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/jquery.dataTables.min.css') }}" />
{{-- <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
{{-- <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/dataTables.bootstrap5.min.css') }}">
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        margin: 0;
        padding: 0;
    }
</style>
@endpush
@push('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
{{-- <script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/jquery.dataTables.js') }}"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/jquery.dataTables.min.js') }}"></script>
{{-- <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script> --}}
{{-- <script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/bootstrap.bundle.js') }}"></script> --}}
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script> --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript">
    $(function() {

        var table = $('#surat-jalan').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('suratjalan') }}",
            columnDefs: [{
                    targets: '_all',
                    className: 'dt-center',
            }],
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'car_id',
                    name: 'car_id',
                    render: function(data, type, full, meta) {
                        return "<span class=\"text-capitalize\">"+ data +"</span>";
                    }
                },
                {
                    data: 'plat',
                    name: 'plat',
                    render: function(data, type, full, meta) {
                        return "<span class=\"text-uppercase\">"+ data +"</span>";
                    }
                },
                {
                    data: 'user_id',
                    name: 'user_id',
                    render: function(data, type, full, meta) {
                        return "<span class=\"text-capitalize\">"+ data +"</span>";
                    }
                },
                {
                    data: 'duration',
                    name: 'duration',
                    render: function(data, type, full, meta) {
                        return "<span class=\"text-capitalize\">"+ data +" Hari</span>";
                    }
                },
                {
                    data: 'total',
                    name: 'total',
                    render: function(data) {
                        return "Rp "+ data;
                    }
                },
                {
                    data: 'tujuan',
                    name: 'tujuan',
                    render: function(data, type, full, meta) {
                        return "<span class=\"text-capitalize\">"+ data +"</span>";
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    render: function(data, type, row) {
                        return "<span class=\"align-middle\">"+ data +"</span>";
                    }
                },
            ],
            language: {
                "sProcessing":   "Memproses...",
                "sLoadingRecords": "Memuat...",
                "sLengthMenu":   "Tampilan _MENU_ Baris",
                "sZeroRecords":  "Data yang Anda cari tidak ditemukan",
                "sInfo":         "Menampilkan _START_-_END_ dari total _TOTAL_ Baris",
                "sInfoEmpty":    "Data Kosong",
                "sInfoFiltered": "(dari keseluruhan data)",
                "sInfoPostFix":  "",
                "sSearch":       "Cari Data:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Pertama",
                    "sPrevious": "Sebelumnya",
                    "sNext":     "Selanjutnya",
                    "sLast":     "Terakhir"
                },
                "aria": {
                    "sortAscending":  ": Tampilan kolom ascending",
                    "sortDescending": ": Tampilan kolom descending"
                }
            }
        });

    });
</script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush

