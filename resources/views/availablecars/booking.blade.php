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
        <li class="breadcrumb-item"><a href="{{ route('transaction.index') }}" class="text-decoration-none">Rental</a></li>
        <li class="breadcrumb-item"><a href="{{ route('availablecar.index') }}" class="text-decoration-none">Data Mobil Tersedia</a></li>
        <li class="breadcrumb-item active" aria-current="page">Booking</li>
    </ol>
</nav>

<div class="card mt-10 mb-5">
    <div class="card-header text-center fw-bold text-uppercase mb-10 bg-primary text-white">
        Booking Mobil {{ $car->name }}
    </div>
    <div class="card-group">
        <div class="card-body mt-3">
            <form action="{{ route('availablecar.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf()
                    <div class="row">
                        <div class="mb-3 card-text form-group col-md-4">
                            <label for="user_id" class="form-label">Pilih Pelanggan</label>
                            <select class="form-select text-capitalize" id="user_id" name="user_id">
                            @foreach($users as $user)
                            <option {{ (old('user_id') == $user->id ? 'selected' : '') }} value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                            </select>
                            @error('user_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 card-text form-group col-md-4">
                            <label for="name" class="form-label">Nama Mobil</label>
                            <input type="text" class="form-control text-capitalize count-chars @error('car_id') is-invalid @enderror" id="car_id" name="car_id" value="{{ old('car_id', $car->id) }}" maxlength="20" data-max-chars="20" hidden>
                            <input type="text" class="form-control text-capitalize count-chars @error('car_name') is-invalid @enderror" id="car_name" name="car_name" value="{{ old('car_id', $car->name) }}" maxlength="20" data-max-chars="20" readonly>
                            <div class="fw-light text-muted justify-content-end d-flex"></div>
                            @error('car_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 card-text form-group col-md-4">
                            <label for="name" class="form-label">Plat Mobil</label>
                            <input type="text" class="form-control text-uppercase count-chars @error('plat') is-invalid @enderror" id="plat" name="plat" value="{{ old('plat', $car->plat) }}" maxlength="20" data-max-chars="20" readonly>
                            <div class="fw-light text-muted justify-content-end d-flex"></div>
                            @error('plat')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 card-text form-group col-md-4">
                            <label for="price" class="form-label">Harga Sewa per Hari</label>
                            <input type="number" class="form-control count-chars @error('price') is-invalid @enderror" name="price" id="price" value="{{ old('price', $car->price) }}" maxlength="10" data-max-chars="10" hidden>
                            <input type="text" class="form-control count-chars @error('view_price') is-invalid @enderror" name="view_price" id="view_price" value="Rp {{ number_format($car->price, 0, ',', '.') }}" maxlength="10" data-max-chars="10" readonly>
                            <div class="fw-light text-muted justify-content-end d-flex"></div>
                            @error('price')
                            <span class="invalid-feedback">
                            {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 card-text form-group col-md-4">
                            <label for="date_start" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control @error('date_start') is-invalid @enderror" name="date_start" id="date_start" value="{{ old('date_start') }}">
                            @error('date_start')
                            <span class="invalid-feedback">
                            {{ $message }}
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3 card-text form-group col-md-4">
                            <label for="date_end" class="form-label">Tanggal Kembali</label>
                            <input type="date" class="form-control @error('date_end') is-invalid @enderror" name="date_end" id="date_end" value="{{ old('date_end') }}">
                            @error('date_end')
                            <span class="invalid-feedback">
                            {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 card-text">
                        <label for="image" class="form-label">Foto Mobil</label>
                        <input type="hidden" name="oldImage" value="{{ $car->image }}">
                        @if($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block" width="400" alt=""> 
                        @else
                        <img src="" class="img-preview img-fluid mb-3 col-sm-5" alt="">
                        @endif
                        @error('image') 
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
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
                    <div class="d-flex justify-content-end mt-3 gap-2">
                        <a href="{{ route('availablecar.index') }}" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-primary">Booking</button>
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

{{-- <script>
     /* Tanpa Rupiah */
     var tanpa_rupiah = document.getElementById('tanpa-rupiah');
    tanpa_rupiah.addEventListener('keyup', function(e)
    {
        tanpa_rupiah.value = formatRupiah(this.value);
    });
    
    /* Dengan Rupiah */
    var dengan_rupiah = document.getElementById('dengan-rupiah');
    dengan_rupiah.addEventListener('keyup', function(e)
    {
        dengan_rupiah.value = formatRupiah(this.value, 'Rp  ');
    });
    
    /* Fungsi */
    function formatRupiah(angka, prefix)
    {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split    = number_string.split(','),
            sisa     = split[0].length % 3,
            rupiah     = split[0].substr(0, sisa),
            ribuan     = split[0].substr(sisa).match(/\d{3}/gi);
            
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script> --}}
@endpush
@endsection