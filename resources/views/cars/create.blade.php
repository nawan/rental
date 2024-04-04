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
  <ol class="breadcrumb my-auto p-2 text-sm">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
      <li class="breadcrumb-item"><a href="{{ route('car.index') }}" class="text text-decoration-none">Mobil</a></li>
      <li class="breadcrumb-item"><a href="{{ route('car.index') }}" class="text text-decoration-none">Data Mobil</a></li>
      <li class="breadcrumb-item active" aria-current="page">Tambah Data Mobil</li>
  </ol>
</nav>

<div class="card mt-10 mb-5">
  <div class="card-header bg-success text-center fw-bold text-uppercase mb-10 text-white">
      Tambah Data Mobil
  </div>
  <div class="card-body bg-light">
      <div class="card-body mt-3">
          <form action="{{ route('car.store') }}" method="POST" enctype="multipart/form-data" class="mb-4">
              @csrf()
              <div class="row">
                <div class="mb-3 card-text form-group col-md-4">
                  <label for="name" class="form-label">Nama Mobil</label>
                  <input type="text" class="form-control text-capitalize count-chars @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" maxlength="20" data-max-chars="20">
                  <div class="fw-light text-muted justify-content-end d-flex"></div>
                  @error('name')
                  <span class="invalid-feedback">{{ $message }}</span>
                  @enderror
                </div>
                <div class="mb-3 card-text form-group col-md-4">
                    <label for="plat" class="form-label">No Plat</label>
                    <input type="text" class="form-control text-uppercase count-chars @error('plat') is-invalid @enderror" name="plat" id="plat" value="{{ old('plat') }}" maxlength="9" data-max-chars="9">
                    <div class="fw-light text-muted justify-content-end d-flex"></div>
                    @error('plat')
                    <span class="invalid-feedback">
                    {{ $message }}
                    </span>
                    @enderror
                </div>
                <div class="mb-3 card-text form-group col-md-4">
                  <label for="price" class="form-label">Harga Sewa</label>
                  <div class="input-group">
                    <div class="input-group-text">Rp</div>
                    <input type="text" class="form-control count-chars @error('price') is-invalid @enderror" name="price" id="currency" value="{{ old('price') }}" maxlength="15" data-max-chars="15">
                  </div>
                  <div class="fw-light text-muted justify-content-end d-flex"></div>
                  @error('price')
                  <span class="invalid-feedback">
                  {{ $message }}
                  </span>
                  @enderror
                </div>
              </div>
              <div class="row">
                <div class="mb-3 card-text form-group col-md-8">
                  <label for="image" class="form-label">Foto Mobil</label>
                  <img src="" class="mb-3 img-preview img-fluid col-sm-5" alt="">
                  <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()">
                  @error('image') 
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>
                <div class="mb-3 form-group col-md-4">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-select" id="status" name="status">
                    <option selected value="1">Tersedia</option>
                    <option value="0">Terpakai</option>
                  </select>
                </div>
              </div>
              <div class="mb-3 card-text">
                <label for="description" class="form-label">Deskripsi Mobil</label>
                <textarea rows="10" name="description" id="description" class="form-control count-chars @error('description') @enderror" maxlength="600" data-max-chars="600">{{ old('description') }}</textarea>
                <div class="fw-light text-muted justify-content-end d-flex"></div>
                @error('description')
                <span class="invalid-feedback">
                {{ $message }}
                </span>
                @enderror
              </div>
              <div class="d-flex justify-content-end mt-3 gap-2">
                <a href="{{ route('car.index') }}" class="btn btn-danger">Batal</a>
                <button type="submit" class="btn btn-success">Simpan</button>
              </div>
          </form>
      </div>
  </div>
</div>

@push('script')
{{-- form validation script --}}
<script type="text/javascript" src="{{ URL::asset('js/form-validation.js') }}"></script>

{{-- currency script --}}
<script type="text/javascript" src="{{ URL::asset('js/currency.js') }}"></script>

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