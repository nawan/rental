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
        <li class="breadcrumb-item"><a href="{{ route('payment.index') }}" class="text-decoration-none">Keuangan</a></li>
        <li class="breadcrumb-item"><a href="{{ route('payment.history') }}" class="text-decoration-none">Riwayat Pembayaran</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Pembayaran</li>
    </ol>
</nav>

<div class="card mt-10 mb-5">
    <div class="card-header text-center fw-bold text-uppercase mb-10 bg-warning text-white">
        Edit Pembayaran Rental Mobil
    </div>
    <div class="card-group">
        <div class="card-body mt-3">
            <form action="{{ route('payment.update', $payment->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf()
                @method('PUT')
                    <div class="row mb-3 card-text">
                        <div class="form-group col-md-6 mb-3">
                            <label for="user_name" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control text-capitalize count-chars @error('user_id') is-invalid @enderror" id="user_id" name="user_id" value="{{ old('user_id', $payment->user_id) }}" maxlength="20" data-max-chars="20" hidden>
                            <input type="text" class="form-control text-capitalize count-chars @error('user_name') is-invalid @enderror" id="user_name" name="user_name" value="{{ old('user_id', $payment->user->name) }}" maxlength="20" data-max-chars="20" readonly>
                            <div class="fw-light text-muted justify-content-end d-flex"></div>
                            @error('user_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control count-chars @error('email') is-invalid @enderror" id="email" name="email" value="{{ $payment->user->email }}" maxlength="20" data-max-chars="20" readonly>
                            @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 card-text">
                        <div class="form-group col-md-4 mb-3">
                            <label for="car_name" class="form-label">Nama Mobil</label>
                            <input type="text" class="form-control text-capitalize count-chars @error('car_id') is-invalid @enderror" id="car_id" name="car_id" value="{{ old('car_id', $payment->car_id) }}" maxlength="20" data-max-chars="20" hidden>
                            <input type="text" class="form-control text-capitalize count-chars @error('car_name') is-invalid @enderror" id="car_name" name="car_name" value="{{ old('car_id', $payment->car->name) }}" maxlength="20" data-max-chars="20" readonly>
                            <div class="fw-light text-muted justify-content-end d-flex"></div>
                            @error('car_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            <label for="car_plat" class="form-label">Plat Mobil</label>
                            <input type="text" class="form-control text-uppercase count-chars @error('plat') is-invalid @enderror" id="plat" name="plat" value="{{ $payment->car->plat }}" maxlength="20" data-max-chars="20" readonly>
                            @error('plat')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            <label for="duration" class="form-label">Durasi Rental</label>
                            <input type="text" class="form-control text-capitalize count-chars @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ $payment->duration }}" maxlength="20" data-max-chars="20" hidden>
                            <input type="text" class="form-control text-capitalize count-chars @error('durasi') is-invalid @enderror" id="durasi" name="durasi" value="{{ $payment->duration }} Hari" maxlength="20" data-max-chars="20" readonly>
                            @error('duration')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3 card-text">
                        <div class="form-group col-md-4 mb-3">
                            <label for="total_price" class="form-label">Total Harga</label>
                            <input type="text" class="form-control count-chars @error('total_price') is-invalid @enderror" name="total_price" id="total_price" value="Rp {{ number_format($payment->total_price, 0, ',', '.') }}" maxlength="10" data-max-chars="10" readonly>
                            <div class="fw-light text-muted justify-content-end d-flex"></div>
                            @error('total_price')
                            <span class="invalid-feedback">
                            {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            <label for="payment_method" class="form-label">Metode Pembayaran</label>
                            <select class="form-select" id="payment_method" name="payment_method">
                                <option value="">-- Pilih Metode Pembayaran --</option>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="qris">QRIS GPN</option>
                            </select>
                            @error('payment_method')
                            <span class="invalid-feedback">
                            {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            <label for="payment_date" class="form-label">Tanggal Pembayaran</label>
                            <input type="date" class="form-control @error('payment_date') is-invalid @enderror" name="payment_date" id="payment_date" value="{{ old('payment_date') }}">
                            @error('date_start')
                            <span class="invalid-feedback">
                            {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 card-text">
                        <label for="image" class="form-label">Foto Bukti Pembayaran</label>
                        <input type="hidden" name="oldImage" value="{{ $payment->payment_proof }}">
                        @if($payment->payment_proof)
                        <img src="{{ asset('storage/' . $payment->payment_proof) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block" width="400" alt=""> 
                        @else
                        <img src="" class="img-preview img-fluid mb-3 col-sm-5" alt="">
                        @endif
                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()" value="{{ old('image', $payment->payment_proof) }}">
                        @error('image') 
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
            </form>
        </div>
    </div>
</div>


@push('script')
{{-- form validation script --}}
<script type="text/javascript" src="{{ URL::asset('js/form-validation.js') }}"></script>

{{-- image preview script --}}
<script>
    function previewImage(){
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');
        imgPreview.style.display = 'block';
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent){
        imgPreview.src = oFREvent.target.result;
      }
    }
  </script>
@endpush
@endsection