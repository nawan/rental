@extends('layouts.main')

@section('content')
<nav aria-label="breadcrumb" class="navbar navbar-light bg-light mb-4 mt-4" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);">
    <ol class="breadcrumb my-auto p-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="#" class="text text-decoration-none">Laporan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Pembayaran</li>
    </ol>
</nav>

<div class="card mt-10 mb-5">
    <div class="card-header text-center fw-bold text-uppercase mb-10 bg-dark text-white">
        Laporan Data Pelanggan
    </div>
    <div class="card-group bg-light mt-10">
        <div class="card">
            <div class="card-body table-responsive text-center mt-5 p-2">
                <div class="table-responsive text-center p-1">
                    <table class="table table-bordered table-hover align-middle stripe display nowrap" id="laporan-pelanggan" style="width: 100%">
                        <thead class="thead thead-light bg-light table-bordered">
                            <tr class="text-white bg-secondary">
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">NIK</th>
                                <th scope="col">KTP</th>
                                <th scope="col">No Hp</th>
                                <th scope="col">email</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Tanggal Daftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="8" class="text-center">
                                    Data Masih Kosong
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- bootstrap@5.3.0-alpha3 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/jquery.dataTables.min.css') }}" />
{{-- datatables css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/dataTables.bootstrap5.min.css') }}">
{{-- datatables responsive css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/responsive.dataTables.min.css') }}">
{{-- datatables row order css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/rowReorder.dataTables.min.css') }}">
{{-- datatable buttons css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/fixedHeader.dataTables.min.css') }}">
{{-- sweet alert2 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/sweet-alert/css/sweetalert2.min.css') }}" />
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
{{-- datatables js --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/dataTables.bootstrap4.min.js') }}"></script>
{{-- datatables responsive js --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/dataTables.responsive.min.js') }}"></script>
{{-- datatables row order js --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/dataTables.rowReorder.min.js') }}"></script>
{{-- datatables button js --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/fixedHeader.dataTables.min.js') }}"></script>
{{-- datatable zip js --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/jszip.min.js') }}"></script>
{{-- datatable make pdf js --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/pdfmake.min.js') }}"></script>
{{-- datatable fonts js --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/vfs_fonts.js') }}"></script>
{{-- datatable button html5 js --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/buttons.html5.min.js') }}"></script>
{{-- datatable button print js --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/buttons.print.min.js') }}"></script>
{{-- swal delete validation script --}}
<script type="text/javascript" src="{{ URL::asset('js/swal-delete.js') }}"></script>

<script type="text/javascript">
    $(function() 
    {
        var table = $('#laporan-pelanggan').DataTable({
            dom: 'Blfrtip',
            lengthMenu: [ 10, 25, 50, 75, 100 ],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            responsive: true,
            fixedHeader: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            processing: true,
            serverSide: true,
            ajax: "{{ route('laporan-pelanggan') }}",
            columnDefs: [{
                    targets: '_all',
                    className: 'dt-center',
            }],
            bJQueryUI:true,
            bSort:true,
            bPaginate:true,
            iDisplayLength: 10,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name',
                    render: function(data, type, full, meta) {
                        return "<span class=\"text-capitalize\">"+ data +"</span>";
                    }
                },
                {
                    data: 'nik',
                    name: 'nik',
                },
                {
                    data: 'ktp',
                    name: 'ktp',
                    render: function(data, type, full, meta) {
                        return "<img src=\"storage/" + data + "\" width=\"120\"/>";
                    },
                },
                {
                    data: 'no_kontak',
                    name: 'no_kontak',
                    render: function(data, type, full, meta) {
                        return "<span class=\"text-uppercase\">"+ data +"</span>";
                    }
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data: 'alamat',
                    name: 'alamat',
                    render: function(data, type, full, meta) {
                        return "<span class=\"text-capitalize\">"+ data +"</span>";
                    }
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                },
            ],
        language: {
                "sProcessing":   "Memproses...",
                "sLoadingRecords": "Memuat...",
                "sLengthMenu":   "Tampilan _MENU_ Baris",
                "sZeroRecords":  "Data yang Anda cari tidak ditemukan",
                "sInfo":         "Menampilkan _START_-_END_ dari _TOTAL_ Baris",
                "sInfoEmpty":    "Data Kosong",
                "sInfoFiltered": "(dari keseluruhan data)",
                "sInfoPostFix":  "",
                "sSearch":       "Cari Data:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "<<",
                    "sPrevious": "<",
                    "sNext":     ">",
                    "sLast":     ">>"
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
