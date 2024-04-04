
@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- bootstrap@5.3.0-alpha3 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/bootstrap.min.css') }}" />
{{-- sweet alert2 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/sweet-alert/css/sweetalert2.min.css') }}" />
{{-- toastr css --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" 
integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" 
crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="text-decoration-none">Pelanggan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Input Data Pelanggan</li>
    </ol>
</nav>

<div class="card mt-10 mb-5">
    <div class="card-header text-center fw-bold text-uppercase mb-10 bg-success text-white">
        Tambah Data Pelanggan
    </div>
    <div class="card-group">
        <div class="card-body">
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf()
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" class="form-control count-chars text-uppercase @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" maxlength="20" data-max-chars="20">
                        <div class="fw-light text-muted justify-content-end d-flex"></div>
                        @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="number" class="form-control count-chars @error('nik') is-invalid @enderror" id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" data-max-chars="16">
                        <div class="fw-light text-muted justify-content-end d-flex"></div>
                        @error('nik')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="no_kontak" class="form-label">No Kontak</label>
                        <input type="number" class="form-control count-chars @error('no_kontak') is-invalid @enderror" id="no_kontak" name="no_kontak" value="{{ old('no_kontak') }}" maxlength="13" data-max-chars="13">
                        <div class="fw-light text-muted justify-content-end d-flex"></div>
                        @error('no_kontak')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" placeholder="nama@email.com">
                        @error('email')
                        <span class="invalid-feedback">
                        {{ $message }}
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Foto KTP</label>
                    <img src="" class="mb-3 img-preview img-fluid col-sm-5" alt="">
                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" onchange="previewImage()">
                    @error('image') 
                    <div class="invalid-feedback">
                    {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control text-capitalize count-chars @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat') }}" maxlength="100" data-max-chars="100"></textarea>
                    <div class="fw-light text-muted justify-content-end d-flex"></div>
                    @error('alamat')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="d-flex justify-content-end mt-3 gap-2">
                    <a href="{{ route('user.index') }}" class="btn btn-danger">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

    
@push('script')
{{-- form validation script --}}
<script type="text/javascript" src="{{ URL::asset('js/form-validation.js') }}"></script>

{{-- jquery image preview --}}
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

{{-- toastr url libs --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" 
integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" 
crossorigin="anonymous" referrerpolicy="no-referrer">
</script>

{{-- progress bar toastr --}}
@if(Session::has('message'))
{{-- <script>
    toastr.success("{{ Session::get('message') }}");
</script> --}}
{{-- <script>
    swal("Message","{{ Session::get('message') }}", 'success',{
        button:true,
        button:"OK",
        timer:6000,
    });
</script> --}}
@endif
@endpush
@endsection