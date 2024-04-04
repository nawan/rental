@extends('layouts.main')

@section('content')
<nav aria-label="breadcrumb" class="navbar navbar-light bg-light mb-4 mt-4" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);">
    <ol class="breadcrumb my-auto p-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home mt-1"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('transaction.index') }}" class="text-decoration-none">Transaksi</a></li>
        <li class="breadcrumb-item active" aria-current="page">Booking</li>
    </ol>
</nav>

<div class="card mt-10 mb-5">
    <div class="card-header text-center fw-bold text-uppercase text-white bg-dark mb-10">
        Daftar Booking
    </div>
    <div class="card-body bg-light mt-10">
        <div class="card-group">
            <div class="d-flex mt-2 mb-2 p-1">
                <a href="{{ route('availablecar.index') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Booking</a>
            </div>
            <div class="card-body table-responsive text-center p-1">
                <table class="table table-bordered table-hover text-center align-middle stripe display nowrap" id="booking-cars" style="width: 100%;">
                    <thead class="thead thead-light bg-light table-bordered">
                        <tr class="text-white bg-secondary">
                            <th scope="col">No</th>
                            <th scope="col">Pelanggan</th>
                            <th scope="col">Mobil</th>
                            <th scope="col">Sewa</th>
                            <th scope="col">Kembali</th>
                            <th scope="col">Status</th>
                            <th scope="col">Total</th>
                            <th scope="col">Aksi</th>
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
@endsection


@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- bootstrap@5.3.0-alpha3 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/bootstrap.min.css') }}" />
{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" /> --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/jquery.dataTables.min.css') }}" />
{{-- <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
{{-- <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
{{-- datatables css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/dataTables.bootstrap5.min.css') }}">
{{-- datatables responsive css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/responsive.dataTables.min.css') }}">
{{-- datatables row order css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/rowReorder.dataTables.min.css') }}">
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
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/dataTables.bootstrap4.min.js') }}"></script>
{{-- datatables responsive js --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/dataTables.responsive.min.js') }}"></script>
{{-- datatables row order js --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/dataTables.rowReorder.min.js') }}"></script>
{{-- sweet alert2 js --}}
<script type="text/javascript" src="{{ URL::asset('assets/sweet-alert/js/sweetalert2.all.min.js') }}"></script>
{{-- sweet alert js --}}
<script type="text/javascript" src="{{ URL::asset('assets/sweet-alert/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip" ]').tooltip();

        var table = $('#booking-cars').DataTable({
            responsive: true,
            rowReorder: {
                selector: 'td:nth-child(2)'
            },
            processing: true,
            serverSide: true,
            ajax: "{{ route('transaction.index') }}",
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
                    name: 'DT_RowIndex',
                },
                {
                    data: 'user_id',
                    name: 'user_id',
                    render: function(data, type, full, meta) {
                        return "<span class=\"text-capitalize\">"+ data +"</span>";
                    }
                },
                {
                    data: 'car_id',
                    name: 'car_id',
                    render: function(data) {
                        return "<span class=\"text-capitalize\">"+data+"</span>";
                    }
                },
                {
                    data: 'date_start',
                    name: 'date_start'
                },
                {
                    data: 'date_end',
                    name: 'date_end'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data, type, full, meta) {
                        if (data == 'PENDING') {
                            return "<span class=\"badge bg-warning\">"+ data +"</span>";
                        }
                        else if (data == 'APPROVED') {
                            return "<span class=\"badge bg-success\">"+ data +"</span>";
                        }
                        else {
                            return "<span class=\"badge bg-info\">"+ data +"</span>";
                        }
                    }
                },
                {
                    data: 'total',
                    name: 'total',
                    render: function(data) {
                        if(data == 0) {
                            return "<span class=\"badge bg-warning\">BELUM APPROVE</span>";
                        }
                        else {
                            return "<span>Rp "+ data +"</span>";
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true,
                    render: function(data){
                        return "<div class=\"d-inline-flex\">"+data+"</div>"
                    }
                },
            ],
            language: {
                "sProcessing":   "Memproses...",
                "sLoadingRecords": "Memuat...",
                "sLengthMenu":   "Tampilan _MENU_ Baris",
                "sZeroRecords":  "Data yang Anda cari tidak ditemukan",
                "sInfo":         "Menampilkan _START_-_END_ dari _TOTAL_ Baris",
                "sInfoEmpty":    "Data Kosong",
                "sInfoFiltered": "(dari total data)",
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
            window.deleteConfirm = function (e) {
            e.preventDefault();
            var form = e.target.form;
            swal({
                title: 'Apakah Anda Yakin?',
                text: 'Data akan dihapus permanen jika Anda melanjutkan proses',
                icon: 'warning',
                buttons: ["Batal", "Hapus"],
                dangerMode: true,
                timer: false,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                    swal("Data Berhasil Dihapus", {
                        icon: "success",
                    });
                }
                else {
                    swal("Anda Membatalkan Proses", {
                        icon: "error",
                    });
                }
            });
        }
</script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
{{-- sweet alert success notification --}}
@if(Session::has('message'))
<script>
    swal("Sukses","{{ Session::get('message') }}", 'success',{
        button:true,
        button:"OK",
        timer:false,
    });
</script>
@endif
{{-- swal delete validation script --}}
{{-- <script type="text/javascript">
    $('.confirm_delete').click(function (event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: 'Apakah Anda Yakin?',
            text: 'Data akan dihapus permanen jika Anda melanjutkan proses',
            icon: 'warning',
            buttons: ["Batal", "Hapus"],
            dangerMode: true,
            timer: 6000,
        })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                    swal("Data Berhasil Dihapus", {
                        icon: "success",
                    });
                }
                else {
                    swal("Anda Membatalkan Proses", {
                        icon: "error",
                    });
                }
            });
    });
</script> --}}
@endpush