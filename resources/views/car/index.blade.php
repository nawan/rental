@extends('layouts.main')

@section('content')
<h1 class="mt-4">Dashboard</h1>
<ol class="mb-4 breadcrumb">
    <li class="breadcrumb-item active">Dashboard</li>
</ol>
<div class="d-flex">
    <a href="{{ route('car.create') }}" class="btn btn-primary">Tambah Mobil</a>
</div>
<table class="table">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nama</th>
      <th scope="col">Image</th>
      <th scope="col">Plat</th>
      <th scope="col">Status</th>
      <th scope="col">Harga</th>
    </tr>
  </thead>
  <tbody>
    @forelse($cars as $car)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $car->name }}</td>
            <td><img src="{{ asset('storage' . $car->image) }}" alt=""></td>
            <td>{{ $car->plat }}</td>
            <td>{{ $car->status }}</td>
            <td>{{ $car->price }}</td>
        </tr>

        {{ $car->links() }}
    @empty
        <tr>
            <td colspan="6" class="text-center">
                Belum ada data
            </td>
        </tr>
    @endforelse
  </tbody>
</table>
@endsection