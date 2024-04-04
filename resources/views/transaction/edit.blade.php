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
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none"><i class="fas fa-home mt-1"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('transaction.index') }}" class="text-decoration-none">Transaksi</a></li>
        <li class="breadcrumb-item"><a href="{{ route('transaction.index') }}" class="text-decoration-none">Booking</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Data Booking</li>
    </ol>
</nav>

<div class="card mt-10 mb-5">
    <div class="card-header text-center fw-bold text-uppercase mb-10 bg-warning text-white">
        Edit Data Booking Mobil Atas Nama {{ $transaction->user->name }}
    </div>
    <div class="card-group">
        <div class="card-body mt-3">
            <form action="{{ route('transaction.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                @csrf()
                @method('PUT')
                {{-- jika select disable maka data tidak terbaca laravel database, anehnya tidak ada notifikasi sama sekali jika gagal input ke database --}}
                {{-- <div class="mb-3">
                    <label for="user_id" class="form-label">Pilih Pelanggan</label>
                    <select class="form-select text-capitalize" id="user_id" name="user_id" disabled="true">
                    @foreach($users as $user)
                    <option {{ (old('user_id', $transaction->user_id) == $user->id ? 'selected' : '') }} value="{{ $user->id }}" selected>{{ $user->name }}</option>
                    @endforeach
                    </select>
                    @error('user_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div> --}}
                {{-- <div class="mb-3 card-text">
                    <label for="name" class="form-label">Nama Pelanggan</label>
                    @foreach ($users as $user)
                    <input type="text" class="form-control text-capitalize count-chars @error('user_id') is-invalid @enderror" id="user_id" name="user_id" value="{{ old('user_id', $user->id) }}" maxlength="20" data-max-chars="20" hidden>
                    <input type="text" class="form-control text-capitalize count-chars @error('user_name') is-invalid @enderror" id="user_name" name="user_name" value="{{ old('user_id', $user->name) }}" maxlength="20" data-max-chars="20" readonly>
                    <div class="fw-light text-muted justify-content-end d-flex"></div>
                    @endforeach
                    @error('car_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 card-text">
                    <label for="name" class="form-label">Nama Mobil</label>
                    @foreach ($cars as $car)
                    <input type="text" class="form-control text-capitalize count-chars @error('car_id') is-invalid @enderror" id="car_id" name="car_id" value="{{ old('car_id', $car->id) }}" maxlength="20" data-max-chars="20" hidden>
                    <input type="text" class="form-control text-capitalize count-chars @error('car_name') is-invalid @enderror" id="car_name" name="car_name" value="{{ old('car_id', $car->name) }}" maxlength="20" data-max-chars="20" readonly>
                    <div class="fw-light text-muted justify-content-end d-flex"></div>
                    @endforeach
                    @error('car_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div> --}}
                <div class="row">
                    <div class="mb-3 card-text form-group col-md-4">
                        <label for="name" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control text-capitalize count-chars @error('user_id') is-invalid @enderror" id="user_id" name="user_id" value="{{ old('user_id', $transaction->user->id) }}" maxlength="20" data-max-chars="20" hidden>
                        <input type="text" class="form-control text-capitalize count-chars @error('user_name') is-invalid @enderror" id="user_name" name="user_name" value="{{ old('user_id', $transaction->user->name) }}" maxlength="20" data-max-chars="20" readonly>
                        <div class="fw-light text-muted justify-content-end d-flex"></div>
                        @error('car_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 card-text form-group col-md-4">
                        <label for="name" class="form-label">Nama Mobil</label>
                        <input type="text" class="form-control text-capitalize count-chars @error('car_id') is-invalid @enderror" id="car_id" name="car_id" value="{{ old('car_id', $transaction->car->id) }}" maxlength="20" data-max-chars="20" hidden>
                        <input type="text" class="form-control text-capitalize count-chars @error('car_name') is-invalid @enderror" id="car_name" name="car_name" value="{{ old('car_id', $transaction->car->name) }}" maxlength="20" data-max-chars="20" readonly>
                        @error('car_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 card-text form-group col-md-4">
                        <label for="name" class="form-label">Plat Mobil</label>
                        <input type="text" class="form-control text-uppercase count-chars @error('plat') is-invalid @enderror" id="plat" name="plat" value="{{ old('plat', $transaction->car->plat) }}" maxlength="20" data-max-chars="20" readonly>
                        @error('plat')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 card-text form-group col-md-4">
                        <label for="date_start" class="form-label">Tanggal Pinjam</label>
                        <input type="date" class="form-control @error('date_start') is-invalid @enderror" name="date_start" id="date_start" value="{{ old('date_start', $transaction->date_start) }}">
                        @error('date_start')
                        <span class="invalid-feedback">
                        {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3 card-text form-group col-md-4">
                        <label for="date_end" class="form-label">Tanggal Kembali</label>
                        <input type="date" class="form-control @error('date_end') is-invalid @enderror" name="date_end" id="date_end" value="{{ old('date_end', $transaction->date_end) }}">
                        @error('date_end')
                        <span class="invalid-feedback">
                        {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3 card-text form-group col-md-4">
                        <label for="price" class="form-label">Total Harga</label>
                        <input type="text" class="form-control count-chars @error('price') is-invalid @enderror" name="price" id="price" value="Rp {{ number_format($transaction->total, 0, ',', '.') }}" maxlength="10" data-max-chars="10" readonly>
                        <div class="fw-light text-muted justify-content-end d-flex"></div>
                        @error('price')
                        <span class="invalid-feedback">
                        {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 card-text">
                    <label for="image" class="form-label">Foto Mobil</label>
                    <input type="hidden" name="oldImage" value="{{ $transaction->car->image }}">
                    @if($transaction->car->image)
                    <img src="{{ asset('storage/' . $transaction->car->image) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block" width="400" alt=""> 
                    @else
                    <img src="" class="img-preview img-fluid mb-3 col-sm-5" alt="">
                    @endif
                    @error('image') 
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Tujuan</label>
                    <textarea name="note" id="note" class="form-control text-capitalize count-chars @error('note') @enderror" maxlength="100" data-max-chars="100">{{ old('note', $transaction->note) }}</textarea>
                    <div class="fw-light text-muted justify-content-end d-flex"></div>
                    @error('note')
                    <span class="invalid-feedback">
                    {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="d-flex justify-content-end mt-3 gap-2">
                    <a href="{{ route('transaction.index') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- form validation script --}}
<script type="text/javascript" src="{{ URL::asset('js/form-validation.js') }}"></script>
@endsection