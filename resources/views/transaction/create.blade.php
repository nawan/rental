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

<nav aria-label="breadcrumb mt-4" class="navbar navbar-light bg-light mb-4 mt-4">
    <ol class="breadcrumb my-auto p-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home mt-1"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('transaction.index') }}" class="text-decoration-none">Transaksi</a></li>
        <li class="breadcrumb-item"><a href="{{ route('transaction.index') }}" class="text-decoration-none">Booking</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Data Booking</li>
    </ol>
</nav>

<div class="card mt-10 mb-5">
    <div class="card-header text-center fw-bold text-uppercase bg-success text-white mb-10">
        Booking Mobil
    </div>
    <div class="card-group">
        <div class="card-body mt-3">
            <form action="{{ route('transaction.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf()
            <div class="mb-3 card-text">
                <label for="user_id" class="form-label">Pilih Pelanggan</label>
                <select class="form-select" id="user_id" name="user_id">
                @foreach($users as $user)
                <option {{ (old('user_id') == $user->id ? 'selected' : '') }} value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
                </select>
                @error('user_id')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 card-text">
                <label for="name" class="form-label">Pilih Mobil</label>
                <select class="form-select" id="car_id" name="car_id">
                    @foreach($cars as $car)
                    <option {{ (old('car_id') == $car->id ? 'selected' : '') }} value="{{ $car->id }}">
                        @if($car->status == 1)
                        {{ $car->name }}
                        @endif
                    </option>
                    @endforeach
                </select>
                @error('car_id')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            {{-- <div class="mb-3 card-text">
                <label for="price" class="form-label">Harga Sewa per Hari</label>
                <input type="number" class="form-control count-chars @error('price') is-invalid @enderror" name="price" id="price" value="{{ number_format($car->price, 0, ',', '.') }}" maxlength="10" data-max-chars="10" readonly>
                <div class="fw-light text-muted justify-content-end d-flex"></div>
                @error('price')
                <span class="invalid-feedback">
                {{ $message }}
                </span>
                @enderror
            </div> --}}
            <div class="mb-3 card-text">
                <label for="date_end" class="form-label">Tanggal Pinjam</label>
                <input type="date" class="form-control @error('date_end') is-invalid @enderror" name="date_start" id="date_start" value="{{ old('date_start') }}">
                @error('date_start')
                <span class="invalid-feedback">
                {{ $message }}
                </span>
                @enderror
            </div>
            <div class="mb-3 card-text">
                <label for="date_end" class="form-label">Tanggal Kembali</label>
                <input type="date" class="form-control @error('date_end') is-invalid @enderror" name="date_end" id="date_end" value="{{ old('date_end') }}">
                @error('date_end')
                <span class="invalid-feedback">
                {{ $message }}
                </span>
                @enderror
            </div>
            <div class="mb-3 card-text">
                <label for="note" class="form-label">Tujuan Pemakaian</label>
                <textarea name="note" id="note" class="form-control text-capitalize count-chars @error('note') @enderror" maxlength="100" data-max-chars="100">{{ old('note') }}</textarea>
                <div class="fw-light text-muted justify-content-end d-flex"></div>
                @error('note')
                <span class="invalid-feedback">
                {{ $message }}
                </span>
                @enderror
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Book</button>
            </div>
            </form>
        </div>
    </div>
</div>
@push('script')
{{-- form validation script --}}
<script type="text/javascript" src="{{ URL::asset('js/form-validation.js') }}"></script>
@endpush
@endsection