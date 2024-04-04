@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- bootstrap@5.3.0-alpha3 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/bootstrap.min.css') }}" />
{{-- sweet alert2 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/sweet-alert/css/sweetalert2.min.css') }}" />
<link rel="stylesheet" href="{{ URL::asset('assets/css/popup-image.css') }}">
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
@endpush

@extends('layouts.main')

@section('content')
<nav aria-label="breadcrumb" class="navbar navbar-light bg-light mb-4 mt-4" style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);">
    <ol class="breadcrumb my-auto p-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home mt-1"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('payment.index') }}" class="text-decoration-none">Keuangan</a></li>
        <li class="breadcrumb-item"><a href="{{ route('payment.history') }}" class="text-decoration-none">Riwayat Pembayaran</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Pembayaran</li>
    </ol>
</nav>


<div class="card bg-light mt-10 mb-5">
    <div class="card-header text-center fw-bold text-uppercase mb-10 bg-info text-white">
    Detail Pembayaran Rental Mobil {{ $payment->car->name }}
    </div>
    <div class="card-group mt-10 mb-2">
        <div class="card-body col-xl-6 col-sm-4">
            <div class="card-header text-center text-white text-uppercase fw-bold bg-secondary">
                <i class="fa fa-cash-register"></i> data pembayaran
            </div>
            <div class="card-group">
                <div class="card-body text-center m-auto bg-white" style="height:350px">
                    <img src="{{ asset('storage/' . $payment->payment_proof) }}" data-bs-toggle="modal" data-bs-target="#detail-payment-proof" class="rounded mx-auto d-block img-thumbnail mb-2" style="max-width: 180px; cursor: pointer;"  alt="">
                </div>

                    {{-- modal view show payment proof --}}
                    <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="detail-payment-proof" tabindex="-1" aria-labelledby="Bukti Bayar {{ $payment->user->name }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="close text-white" data-bs-dismiss="modal"><i class="fa" style="font-size: 2rem;">&#xf00d;</i></button>
                                </div>
                                <div class="modal-body d-flex justify-content-center">
                                    <img src="{{ asset('storage/' . $payment->payment_proof) }}" style="width:100%;max-width:450px">
                                </div>
                            </div>
                        </div>
                    </div>

                @php 
                    $encryptID = Crypt::encrypt($payment->user_id); 
                @endphp
                <div class="card-body bg-white" style="height:350px">
                    <p class="card-text fw-bold m-2">Kode Pembayaran : <span class="fst-italic fw-normal text-uppercase">{{ $payment->payment_code }}</span></p>
                    <p class="card-text fw-bold m-2">Harga Sewa : <span class="fst-italic fw-normal">Rp  {{ number_format($payment->car->price, 0, ',', '.') }} per Hari</span></p>
                    <p class="card-text fw-bold m-2">Durasi Sewa : <span class="fst-italic fw-normal">{{ $payment->duration }} Hari</span></p>
                    <p class="card-text fw-bold m-2">Total Pembayaran : <span class="fst-italic fw-normal">Rp  {{ number_format($payment->total_price, 0, ',', '.') }}</span></p>
                    <p class="card-text fw-bold m-2">Tanggal Pembayaran : <span class="fst-italic fw-normal text-capitalize">{{ \Carbon\Carbon::parse($payment->payment_date)->isoFormat('dddd, D MMMM Y') }} </span></p>
                    <p class="card-text fw-bold m-2">Metode Pembayaran : <span class="fst-italic fw-normal text-uppercase">{{ $payment->payment_method }} </span></p>
                    <p class="card-text fw-bold m-2">Diterima Oleh : <span class="fst-italic text-capitalize text-primary">{{ $payment->created_by }} <i class="fa fa-check-circle fst-italic"></i></span></p>
                </div>
            </div>
        </div>
    </div>
    <div class="card-group mt-10 mb-2">
        <div class="card-body col-xl-6 col-sm-4 text-center">
            <div class="card-header text-center text-white text-uppercase fw-bold bg-secondary">
            <i class="fa fa-user"></i> data pelanggan
            </div>
            <div class="card-body bg-white" style="height:600px">
            @if($payment->user->image)  
            <img src="{{ asset('storage/' . $payment->user->image) }}" class="rounded mx-auto d-block img-thumbnail mb-2" style="cursor: pointer;" width="150" height="auto" alt="" data-bs-toggle="modal" data-bs-target="#detail-user-image">
            @else
            <img src="{{ $payment->user->gravatar }}" width="300" alt="">
            @endif

                {{-- modal view show user image --}}
                <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="detail-user-image" tabindex="-1" aria-labelledby="Foto KTP {{ $payment->user->name }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="close text-white" data-bs-dismiss="modal"><i class="fa" style="font-size: 2rem;">&#xf00d;</i></button>
                            </div>
                            <div class="modal-body d-flex justify-content-center">
                                <img src="{{ asset('storage/' . $payment->user->image) }}" style="width:100%;max-width:500px">
                            </div>
                        </div>
                    </div>
                </div>

            <p class="card-title text-capitalize fw-bold mb-3 h4">{{ $payment->user->name }}</p>
            <p class="card-text fw-bold m-0">No Kontak</p>
            <p class="fst-italic mb-2">{{ $payment->user->no_kontak }}</p>
            <p class="card-text fw-bold m-0">Alamat</p>
            <p class="fst-italic text-capitalize mb-2">{{ $payment->user->alamat }}</p>
            <p class="card-text fw-bold m-0">Tanggal Pinjam</p>
            <p class="fst-italic mb-2">{{ \Carbon\Carbon::parse($payment->transaction->date_start)->isoFormat('dddd, D MMMM Y') }}</p>
            <p class="card-text fw-bold m-0">Tanggal Kembali</p>
            <p class="fst-italic mb-2">{{ \Carbon\Carbon::parse($payment->transaction->date_end)->isoFormat('dddd, D MMMM Y') }}</p>
            <p class="card-text fw-bold m-0">Tujuan Pemakaian</p>
            <p class="fst-italic text-capitalize mb-2">{{ $payment->transaction->note }}</p>
            <p class="card-text fw-bold m-0">Durasi Sewa</p>
            <p class="fst-italic text-capitalize mb-2">
                {{ $payment->duration }} Hari
            </p>
            </div>
            <div class="card-footer bg-white d-flex align-items-center justify-content-between fw-bold">
            @php $encryptID = Crypt::encrypt($payment->user->id); @endphp
            <a href="{{ route('user.show', $encryptID) }}" class="btn-sm btn-secondary fw-bold text-decoration-none">Lihat Detail Pelanggan</a>
            <div class="small">
                <i class="fas fa-angle-right"></i>
            </div>
            </div>
        </div>

        <div class="card-body col-xl-6 col-sm-4 text-center">
            <div class="card-header text-center text-white text-uppercase fw-bold bg-secondary">
            <i class="fa fa-car"></i> data mobil
            </div>
            <div class="card-body bg-white" style="height:600px">
            <img src="{{ asset('storage/' . $payment->car->image) }}" class="rounded mx-auto d-block img-thumbnail mb-2" style="cursor: pointer;" width="250"  alt="" data-bs-toggle="modal" data-bs-target="#detail-car-image">

                {{-- modal view show user image --}}
                <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="detail-car-image" tabindex="-1" aria-labelledby="Foto Mobil {{ $payment->car->name }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="close text-white" data-bs-dismiss="modal"><i class="fa" style="font-size: 2rem;">&#xf00d;</i></button>
                            </div>
                            <div class="modal-body d-flex justify-content-center">
                                <img src="{{ asset('storage/' . $payment->car->image) }}" style="width:100%;max-width:500px">
                            </div>
                        </div>
                    </div>
                </div>

            <p class="card-title text-capitalize fw-bold h4 mb-3">{{ $payment->car->name }}</p>
            <p class="card-text fw-bold m-0">Nomor Plat</p>
            <p class="fst-italic text-uppercase mb-2">{{ $payment->car->plat }}</p>
            <p class="card-text fw-bold m-0">Harga Sewa</p>
            <p class="fst-italic mb-2">Rp  {{ number_format($payment->car->price, 0, ',', '.') }} <span class="text text-sm">per Hari</span></p>
            <p class="card-text fw-bold m-0">Status Rental</p>
            <p class="mb-2">
                <span class="text-uppercase m-3">
                @if($payment->transaction->status == 'PENDING')
                <span class="badge bg-warning">PENDING</span>
                @else
                <span class="badge bg-success">APPROVED</span>
                @endif
                </span>
            </p>
            </div>
            <div class="card-footer bg-white d-flex align-items-center justify-content-between fw-bold">
            @php $encryptID = Crypt::encrypt($payment->car->id); @endphp
            <a href="{{ route('car.show', $encryptID) }}" class="btn-sm btn-secondary fw-bold text-decoration-none">Lihat Detail Mobil</a>
            <div class="small">
                <i class="fas fa-angle-right"></i>
            </div>
            </div>
        </div>
    </div>
</div>


@endsection