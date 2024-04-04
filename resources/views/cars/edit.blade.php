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
        <li class="breadcrumb-item"><a href="{{ route('car.index') }}" class="text-decoration-none">Data Mobil</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Data Mobil</li>
    </ol>
</nav>

<div class="card mt-10 mb-5">
    <div class="card-header text-center fw-bold text-uppercase mb-10 bg-warning text-white">
        Edit Data Mobil {{ $car->name }}
    </div>
    <div class="card-group">
        <div class="card-body mt-3">
            <form action="{{ route('car.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                @csrf()
                @method('PUT')
                    <div class="row">
                        <div class="mb-3 card-text form-group col-md-4">
                            <label for="name" class="form-label">Nama Mobil</label>
                            <input type="text" class="form-control text-capitalize count-chars @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $car->name) }}" maxlength="20" data-max-chars="20">
                            <div class="fw-light text-muted justify-content-end d-flex"></div>
                            @error('name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 card-text form-group col-md-4">
                            <label for="plat" class="form-label">No Plat</label>
                            <input type="text" class="form-control text-uppercase count-chars @error('plat') is-invalid @enderror" name="plat" id="plat" value="{{ old('plat', $car->plat) }}" maxlength="9" data-max-chars="9">
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
                                <input type="text" class="form-control count-chars @error('price') is-invalid @enderror" name="price" id="currency" value="{{ number_format($car->price, 0, ',', '.') }}" maxlength="15" data-max-chars="15">
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
                            <input type="hidden" name="oldImage" value="{{ $car->image }}">
                            @if($car->image)
                            <img src="{{ asset('storage/' . $car->image) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block" width="400" alt=""> 
                            @else
                            <img src="" class="img-preview img-fluid mb-3 col-sm-5" alt="">
                            @endif
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()" value="{{ old('image', $car->image) }}">
                            @error('image') 
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 card-text form-group col-md-4">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                            <option {{ ($car->status == 1) ? 'selected' : '' }} value="1" >Tersedia</option>
                            <option {{ ($car->status == 0) ? 'selected' : '' }} value="0">Terpakai</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 card-text">
                        <label for="description" class="form-label">Deskripsi Mobil</label>
                        <textarea rows="10" name="description" id="description" class="form-control count-chars @error('description') @enderror" maxlength="600" data-max-chars="600">{{ old('description', $car->description) }}</textarea>
                        <div class="fw-light text-muted justify-content-end d-flex"></div>
                        @error('description')
                        <span class="invalid-feedback">
                        {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end mt-3 gap-2">
                        <a href="{{ route('car.index') }}" class="btn btn-danger">Batal</a>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
            </form>
        </div>
    </div>
</div>

{{-- <form action="{{ route('car.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="mb-4">
    @csrf()
    @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $car->name) }}">
            @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="plat" class="form-label">Plat</label>
            <input type="text" class="form-control @error('plat') is-invalid @enderror" name="plat" id="plat" value="{{ old('plat', $car->plat) }}">
            @error('plat')
            <span class="invalid-feedback">
            {{ $message }}
            </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Gambar</label>
            <input type="hidden" name="oldImage" value="{{ $car->image }}">
            @if($car->image)
            <img src="{{ asset('storage/' . $car->image) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block" alt=""> 
            @else
            <img src="" class="img-preview img-fluid mb-3 col-sm-5" alt="">
            @endif
            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()" value="{{ old('image', $car->image) }}">
            @error('image') 
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" id="price" value="{{ old('price', $car->price) }}">
            @error('price')
            <span class="invalid-feedback">
            {{ $message }}
            </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" class="form-control @error('description') @enderror">{{ old('description', $car->description) }}</textarea>
            @error('description')
            <span class="invalid-feedback">
            {{ $message }}
            </span>
            @enderror
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
            <option {{ ($car->status == 1) ? 'selected' : '' }} value="1" >Tersedia</option>
            <option {{ ($car->status == 0) ? 'selected' : '' }} value="0">Terpakai</option>
            </select>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-success">Update</button>
        </div>
</form> --}}

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