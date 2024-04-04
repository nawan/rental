@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- bootstrap@5.3.0-alpha3 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/bootstrap.min.css') }}" />
{{-- sweet alert2 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/sweet-alert/css/sweetalert2.min.css') }}" />
<style>
    .modal-content {
    background-color: transparent !important;
    border: 0px !important
    }

    .modal-header-popup-image {
        border: 0px !important
    }
</style>
@endpush

@push('script')
{{-- sweet alert2 js --}}
<script type="text/javascript" src="{{ URL::asset('assets/sweet-alert/js/sweetalert2.all.min.js') }}"></script>
{{-- sweet alert js --}}
<script type="text/javascript" src="{{ URL::asset('assets/sweet-alert/js/sweetalert.min.js') }}"></script>
{{-- jquery jscript --}}
<script type="text/javascript" src="{{ URL::asset('assets/jquery/jquery-3.6.4.slim.js') }}"></script>
{{-- bootstrap@5.3.0-alpha3 jscript --}}
{{-- <script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/bootstrap.bundle.min.js') }}"></script> --}}
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush

@extends('layouts.main')

@section('content')

<nav aria-label="breadcrumb" class="navbar navbar-light bg-light mb-4 mt-4" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);">
    <ol class="breadcrumb my-auto p-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home mt-1"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}" class="text-decoration-none">Admin</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}" class="text-decoration-none">Data Admin</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Data Admin</li>
    </ol>
</nav>

{{-- users detail --}}
<div class="card mt-10 mb-5">
    <div class="card-header text-center fw-bold text-uppercase mb-10 bg-info text-white">
        Detail Data Admin
    </div>
    <div class="card-group bg-light mt-10">
        <div class="card-body text-center col-sm-4">
            <div class="card-header text-center text-uppercase fw-bold bg-secondary text-white">
                foto profil
            </div>
            <div class="card-title bg-white p-5" style="height: 400px">
                @if($user->image)  
                <img src="{{ asset('storage/' . $user->image) }}" class="rounded img-thumbnail" width="250" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#detail-ktp">
                @else
                <img src="{{ $user->gravatar }}" class="rounded mx-auto d-block img-thumbnail" width="400" alt="">
                @endif
            </div>

                {{-- modal view show KTP --}}
                <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="detail-ktp" tabindex="-1" aria-labelledby="Foto KTP {{ $user->name }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="close text-white" data-bs-dismiss="modal"><i class="fa" style="font-size: 2rem;">&#xf00d;</i></button>
                            </div>
                            <div class="modal-body d-flex justify-content-center">
                                <img src="{{ asset('storage/' . $user->image) }}" style="width:100%;max-width:500px">
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="card-body text-center col-sm-4">
            <div class="card-header text-center text-uppercase fw-bold bg-secondary text-white">
                Data Pelanggan
            </div>
            <div class="card-title bg-white p-3" style="height: 400px">
                <p class="card-text fw-bold m-0">Nama</p>
                <p class="fst-italic text-capitalize mb-2">{{ $user->name }}</p>
                <p class="card-text fw-bold m-0">NIK</p>
                <p class="fst-italic text-uppercase mb-2">{{ $user->nik }}</p>
                <p class="card-text fw-bold m-0">No Kontak</p>
                <p class="fst-italic text-uppercase mb-2"><a href="https://wa.me/" target="_blank">{{ $user->no_kontak  }}</a></p>
                <p class="card-text fw-bold m-0">Email</p>
                <p class="fst-italic mb-2">{{ $user->email }}</p>
                <p class="card-text fw-bold m-0">Alamat</p>
                <p class="fst-italic text-capitalize mb-2">{{ $user->alamat }}</p>
                <p class="card-text fw-bold m-0">Terdaftar Sejak</p>
                <p class="fst-italic mb-2">{{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</p>
            </div>
        </div>
    </div>
</div>


{{-- users rental history --}}
<div class="card mt-5 mb-5">
    <div class="card-header text-center text-uppercase fw-bold bg-success text-white">
        riwayat approval mobil
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover text-center align-middle stripe" id="cars-history" style="width:100%;">
            <thead class="thead thead-light bg-secondary text-white table-bordered">
                <tr class="text-center">
                    <th scope="col">No</th>
                    <th scope="col">Pelanggan</th>
                    <th scope="col">Mobil</th>
                    <th scope="col">Durasi</th>
                    <th scope="col">Approval</th>
                    <th scope="col">Pembayaran</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-capitalize">{{ $payment->user->name }}</td>
                    <td class="text-capitalize">{{ $payment->car->name }}</td>
                    <td class="text-capitalize">{{ $payment->duration }} Hari</td>
                    <td class="text-capitalize">{{ \Carbon\Carbon::parse($payment->transaction->date_start)->isoFormat('D MMMM Y') }}</td>
                    <td class="text-capitalize">{{ \Carbon\Carbon::parse($payment->payment_date)->isoFormat('D MMMM Y') }}</td>
                    <td class="text-capitalize">
                        @php $encryptID = Crypt::encrypt($payment->id); @endphp
                        <a href="{{ route('payment.show', $encryptID) }}" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Detail Approval"><i class="fa fa-eye"></i></a>
                    </td>
                    {{-- <td>{{ \Carbon\Carbon::parse($transaction->date_start)->isoFormat('D MMMM Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->date_end)->isoFormat('D MMMM Y') }}</td>
                    <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                    <td class="text-capitalize">{{ $transaction->note }}</td>
                    <td class="text-uppercase">
                        @if($transaction->status == 'APPROVED')
                        <span class="badge bg-danger">Belum Kembali</span>
                        @elseif($transaction->status == 'PENDING')
                        <span class="badge bg-warning">BOOKED</span>
                        @else
                        <span class="badge bg-info">Kembali</span>
                        @endif
                    </td> --}}
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Data Masih Kosong
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $payments->links() }}
    </div>
</div>
@endsection