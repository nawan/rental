@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- bootstrap@5.3.0-alpha3 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/bootstrap.min.css') }}" />
{{-- sweet alert2 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/sweet-alert/css/sweetalert2.min.css') }}" />
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
        <li class="breadcrumb-item"><a href="{{ route('car.index') }}" class="text-decoration-none">Mobil</a></li>
        <li class="breadcrumb-item"><a href="{{ route('car.index') }}" class="text-decoration-none">Daftar Mobil</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Data Mobil</li>
    </ol>
</nav>

{{-- cars detail --}}
<div class="card mt-10 mb-5">
    <div class="card-header text-center fw-bold text-uppercase mb-10 bg-success text-white">
        Detail Data mobil
    </div>
    <div class="card-group bg-light mt-10">
        <div class="card-body text-center col-sm-4">
            <div class="card-header text-center text-uppercase fw-bold bg-secondary text-white">
                foto mobil
            </div>
            <div class="card-title bg-white p-5" style="height: 400px">
                <p class="card-title text-capitalize fw-bold mb-2 h4">
                    <img src="{{ asset('storage/' . $car->image) }}" class="rounded img-thumbnail" width="350" alt="">
                </p>
                <p class="card-text fw-bold m-0">Deskripsi Mobil</p>
                <p class="fst-italic mb-2 text-capitalize">{{ $car->description }}</p>
            </div>
        </div>
        <div class="card-body text-center col-sm-4">
            <div class="card-header text-center text-uppercase fw-bold bg-secondary text-white">
                Data Mobil
            </div>
            <div class="card-title bg-white p-3" style="height: 400px">
                <p class="card-text fw-bold m-0">Nama Mobil</p>
                <p class="fst-italic text-capitalize mb-2">{{ $car->name }}</p>
                <p class="card-text fw-bold m-0">No Plat</p>
                <p class="fst-italic text-uppercase mb-2">{{ $car->plat }}</p>
                <p class="card-text fw-bold m-0">Harga Sewa</p>
                <p class="fst-italic text-capitalize mb-2">Rp {{ number_format($car->price, 0, ',', '.') }}</p>
                <p class="card-text fw-bold m-0">Status Ketersediaan</p>
                <p class="fst-italic mb-2">
                    @if($car->status == 1)
                    <span class="badge bg-success">Tersedia</span>
                    @else
                    <span class="badge bg-danger">Terpakai</span>
                    @endif
                </p>
                <p class="card-text fw-bold m-0">Tanggal Registrasi Mobil</p>
                <p class="fst-italic text-capitalize mb-2">{{ \Carbon\Carbon::parse($car->created_at)->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
        </div>
    </div>
</div>

{{-- cars table history --}}
<div class="card mt-5 mb-5">
    <div class="card-header text-center text-uppercase fw-bold bg-success text-white">
        riwayat penggunaan mobil
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover text-center align-middle stripe" id="cars-history" style="width:100%;">
            <thead class="thead thead-light bg-secondary text-white table-bordered">
                <tr class="text-center">
                    <th scope="col">No</th>
                    <th scope="col">Pelanggan</th>
                    <th scope="col">Sewa</th>
                    <th scope="col">Kembali</th>
                    <th scope="col">Total</th>
                    <th scope="col">Tujuan</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-capitalize">{{ $transaction->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($transaction->date_start)->isoFormat('D MMMM Y') }}</td>
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
                        </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Data Masih Kosong
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        {{ $transactions->links() }}
    </div>
</div>
@endsection
@push('style')
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        margin: 0;
        padding: 0;
    }
</style>
@endpush