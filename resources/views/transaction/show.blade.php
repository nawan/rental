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
      <li class="breadcrumb-item"><a href="{{ route('transaction.index') }}" class="text-decoration-none">Transaksi</a></li>
      <li class="breadcrumb-item"><a href="{{ route('transaction.index') }}" class="text-decoration-none">Booking</a></li>
      <li class="breadcrumb-item active" aria-current="page">Detail Booking</li>
  </ol>
</nav>


    <div class="card mt-10 mb-5">
      <div class="card-header text-center fw-bold text-uppercase mb-10 bg-info text-white">
        Detail Booking Mobil {{ $transaction->car->name }}
      </div>
      <div class="card-group mt-10">
        <div class="card-body col-sm-4 bg-light text-center">
          <div class="card-header text-center text-white text-uppercase fw-bold bg-secondary">
            <i class="fa fa-user"></i> data pelanggan
          </div>
          <div class="card-body bg-white" style="height:550px">
            @if($transaction->user->image)  
            <img src="{{ asset('storage/' . $transaction->user->image) }}" class="rounded mx-auto d-block img-thumbnail mb-2" width="250" alt="">
            @else
            <img src="{{ $transaction->user->gravatar }}" width="300" alt="">
            @endif
            <p class="card-title text-capitalize fw-bold mb-3 h4">{{ $transaction->user->name }}</p>
            <p class="card-text fw-bold m-0">Tanggal Pinjam</p>
            <p class="fst-italic mb-2">{{ \Carbon\Carbon::parse($transaction->date_start)->isoFormat('dddd, D MMMM Y') }}</p>
            <p class="card-text fw-bold m-0">Tanggal Kembali</p>
            <p class="fst-italic mb-2">{{ \Carbon\Carbon::parse($transaction->date_end)->isoFormat('dddd, D MMMM Y') }}</p>
            <p class="card-text fw-bold m-0">Tujuan Pemakaian</p>
            <p class="fst-italic text-capitalize mb-2">{{ $transaction->note }}</p>
            <p class="card-text fw-bold m-0">Total Biaya</p>
            <p class="fst-italic text-capitalize mb-2">
                Rp {{ number_format($transaction->total, 0, ',', '.') }}
            </p>
          </div>
          <div class="card-footer bg-white d-flex align-items-center justify-content-between fw-bold">
            @php $encryptID = Crypt::encrypt($transaction->user->id); @endphp
            <a href="{{ route('user.show', $encryptID) }}" class="btn-sm btn-secondary fw-bold text-decoration-none">Lihat Detail Pelanggan</a>
            <div class="small">
              <i class="fas fa-angle-right"></i>
            </div>
          </div>
        </div>

        <div class="card-body col-sm-4 bg-light text-center">
          <div class="card-header text-center text-white text-uppercase fw-bold bg-secondary">
            <i class="fa fa-car"></i> data mobil
          </div>
          <div class="card-body bg-white" style="height:550px">
            <img src="{{ asset('storage/' . $transaction->car->image) }}" class="rounded mx-auto d-block img-thumbnail mb-2" width="250"  alt="">
            <p class="card-title text-capitalize fw-bold h4 mb-3">{{ $transaction->car->name }}</p>
            <p class="card-text fw-bold m-0">Nomor Plat</p>
            <p class="fst-italic text-uppercase mb-2">{{ $transaction->car->plat }}</p>
            <p class="card-text fw-bold m-0">Harga Sewa</p>
            <p class="fst-italic mb-2">Rp  {{ number_format($transaction->car->price, 0, ',', '.') }} <span class="text text-sm">per Hari</span></p>
            {{-- <p class="card-text fw-bold m-0">Status Mobil</p>
            <p class="mb-2">
              <span class="text-uppercase m-3">
                @if($transaction->car->status == 1)
                <span class="badge bg-success">Tersedia</span>
                @else
                <span class="badge bg-danger">Terpakai</span>
                @endif
              </span>
            </p> --}}
            <p class="card-text fw-bold m-0">Status Rental</p>
            <p class="mb-2">
              <span class="text-uppercase m-3">
                @if($transaction->status == 'PENDING')
                <span class="badge bg-warning">PENDING</span>
                @else
                <span class="badge bg-success">APPROVED</span>
                @endif
              </span>
            </p>
          </div>
          <div class="card-footer bg-white d-flex align-items-center justify-content-between fw-bold">
            @php $encryptID = Crypt::encrypt($transaction->car->id); @endphp
            <a href="{{ route('car.show', $encryptID) }}" class="btn-sm btn-secondary fw-bold text-decoration-none">Lihat Detail Mobil</a>
            <div class="small">
              <i class="fas fa-angle-right"></i>
            </div>
          </div>
        </div>
      </div>
    </div>


@endsection