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
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('car.index') }}" class="text text-decoration-none">Mobil</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Mobil</li>
    </ol>
</nav>


<div class="card mt-10 mb-5">
    <div class="card-header text-center fw-bold text-uppercase mb-10 bg-dark text-white">
        Data Mobil
    </div>
    <div class="card-body">
        <div class="d-flex mt-4 mb-3">
            <a href="{{ route('car.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus-square"></i> Tambah Mobil</a>
        </div>
        <div class="justify-content-center">
            <form action="{{ route('car.index') }}" method="GET">
                <div class="row">
                    <div class="col">
                        <div class="input-group mb-3">
                            <input type="text" value="{{ Request::input('search') }}" class="form-control" placeholder="Search..." name="search">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-hover table-responsive">
            <thead class="thead-light">
            <tr class="text-center bg-light">
                <th scope="col">No</th>
                <th scope="col">Nama</th>
                <th scope="col">Foto</th>
                <th scope="col">Plat</th>
                <th scope="col">Status</th>
                <th scope="col">Harga</th>
                <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($cars as $car)
                <tr class="mt-2 align-middle text-center">
                    <input type="hidden" class="delete_id" value="{{ $car->id }}">
                    <input type="hidden" class="name" value="{{ $car->name }}">
                    <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
                    <td class="align-middle text-capitalize">{{ $car->name }}</td>
                    <td><img src="{{ asset('storage/' . $car->image) }}" alt="" width="150" height="75"></td>
                    <td class="align-middle text-uppercase">{{ $car->plat }}</td>
                    <td class="align-middle">
                        @if($car->status == 1)
                        <span class="badge bg-success">Tersedia</span>
                        @else
                        <span class="badge bg-danger">Terpakai</span>
                        @endif</td>
                    </td>
                    <td class="align-middle text-right">Rp {{ number_format($car->price,0,',','.') }}</td>
                    <td class="align-middle">
                        <form method="POST" action="{{ route('car.destroy', $car->id) }}" class="d-inline">
                            @csrf
                            @method('delete')
                            <input name="_method" type="hidden" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger btn-flat show_confirm" data-toggle="tooltip" data-placement="top" title="Hapus"><i class="fa fa-trash"></i></button>
                        </form>
                        @php $encryptID = Crypt::encrypt($car->id); @endphp
                        <a href="{{ route('car.edit', $encryptID) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Info" data-bs-toggle="modal" data-bs-target="#detail{{ $car->id }}"><i class="fa fa-eye"></i></button>

                            {{-- modal view show --}}
                            <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="detail{{ $car->id }}" tabindex="-1" aria-labelledby="detail{{ $car->id }}Label" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                    <div class="modal-content">
                                        <div class="card mt-10">
                                            <div class="card-header text-center fw-bold text-uppercase mb-10 bg-info text-white">
                                                Detail Data Mobil {{ $car->name }}
                                            </div>
                                            <div class="card-group bg-light mt-10">
                                                <div class="card">
                                                    <div class="card-header text-center text-uppercase fw-bold mb-3">
                                                        Foto Mobil
                                                    </div>
                                                    <div class="card-body text-center" style="400px">
                                                        <p class="card-title text-capitalize fw-bold mb-0 h4">
                                                            <img src="{{ asset('storage/' . $car->image) }}" class="rounded mx-auto" width="400" alt="">
                                                        </p>
                                                        <p class="card-text fw-bold m-0">Deskripsi Mobil</p>
                                                        <p class="fst-italic mb-2 text-capitalize">{{ $car->description }}</p>
                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header text-center text-uppercase fw-bold mb-3">
                                                        Data Mobil
                                                    </div>
                                                    <div class="cad-body text-center m-auto" style="400px">
                                                        <p class="card-text fw-bold m-0">Nama Mobil</p>
                                                        <p class="fst-italic text-capitalize mb-2">{{ $car->name }}</p>
                                                        <p class="card-text fw-bold m-0">No Plat</p>
                                                        <p class="fst-italic text-uppercase mb-2">{{ $car->plat }}</p>
                                                        <p class="card-text fw-bold m-0">Harga Sewa</p>
                                                        <p class="fst-italic text-capitalize mb-2">Rp {{ number_format($car->price, 0, ',', '.') }}</p>
                                                        <p class="card-text fw-bold m-0">Status Ketersediaan</p>
                                                        <p class="mb-2 text-lg">
                                                            @if($car->status == 1)
                                                            <span class="badge bg-success">Tersedia</span>
                                                            @else
                                                            <span class="badge bg-danger">Terpakai</span>
                                                            @endif
                                                        </p>
                                                        <p class="card-text fw-bold m-0">Tanggal Registrasi Mobil</p>
                                                        <p class="fst-italic text-capitalize mb-2">{{ \Carbon\Carbon::parse($car->created_at)->isoFormat('dddd, D MMMM Y') }}</p>
                                                        <button type="button" class="btn btn-info btn-sm mb-3"><a href="{{ route('car.show', $encryptID) }}" class="text-white" style="text-decoration: none">Lihat Detail</a></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Data Tidak Ditemukan <br/>
                        <a href="{{ route('car.index') }}" class="btn btn-info"><i class="fa fa-refresh"></i> Refresh</a>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $cars->links() }}
    </div>
</div>

@push('script')

{{-- swal delete validation script --}}
<script type="text/javascript" src="{{ URL::asset('js/swal-delete.js') }}"></script>

{{-- sweet alert success notification --}}
@if(Session::has('message'))
<script>
    swal("Sukses","{{ Session::get('message') }}", 'success',{
        button:true,
        button:"OK",
        timer:false,
    });
</script>
@endif


<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush

@endsection