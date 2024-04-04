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
        <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Cetak</a></li>
        <li class="breadcrumb-item"><a href="{{ route('buktibayar') }}" class="text-decoration-none">Bukti Bayar</a></li>
        <li class="breadcrumb-item active" aria-current="page">Receipt</li>
    </ol>
</nav>

<div class="card mt-10 mb-5">
    <div class="card-header text-center fw-bold text-uppercase text-white bg-dark mb-10">
        Cetak Nota Pembayaran
    </div>
    <div class="card-body bg-light mt-10">
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card" id="print_receipt">
                            <div class="card-body">
                                {{-- company title receipt --}}
                                <div class="invoice-title">
                                    <h4 class="float-end">
                                        {{-- <button class="btn btn-primary" onclick="window.print()"><i class="fa fa-print"></i> Cetak</a></button> --}}
                                        @php $encryptID = Crypt::encrypt($payment->id); @endphp
                                        {{-- {{ $encryptID = Crypt::encrypt($payment->id); }} --}}
                                        <a href="{{ route("cetakreceipt", $encryptID) }}" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Cetak</a>
                                    </h4>
                                    <div class="mb-2">
                                        <img src="{{ URL::asset('/assets/img/logo-blue.png') }}" class="navbar-brand-img" data-holder-rendered="true" height="auto" width="400px" />
                                    </div>
                                    <div class="text-muted">
                                        <p class="mb-1">Jl Parangtritis KM 5 Pendowoharjo Sewon Bantul</p>
                                        <p class="mb-1"><i class="fa fa-home"></i> <a href="https://nawan.vercel.app/" target="_blank">www.nawansite.com</a></p>
                                        <p class="mb-1"><i class="fa fa-envelope"></i> rental@nawansite.com</p>
                                        <p class="mb-1"> <i class="fa fa-phone"></i> 081222333444</p>
                                    </div>
                                </div>
                                <hr class="my-4">
                                {{-- client title receipt --}}
                                <div class="row">
                                    {{-- col 1 --}}
                                    <div class="col-sm-6">
                                        <div class="text-muted">
                                            <p class="h5 mb-2">Telah diterima pembayaran rental dari :</p>
                                            <p class="mb-1 fw-bold text-capitalize" style="font-size: 1.5rem"> {{ $payment->user->name }}</p>
                                            <p class="mb-0" style="font-size: 1rem">{{ $payment->user->no_kontak }}</p>
                                            <p class="mb-0 text-capitalize" style="font-size: 1rem">{{ $payment->user->alamat }}</p>
                                        </div>
                                    </div>
                                    {{-- col 2 --}}
                                    <div class="col-sm-6">
                                        <div class="text-muted text-sm-end">
                                            <p class="h5 mb-1">Kode Pembayaran</p>
                                            <p class="fw-bold fst-italic text-uppercase mb-2" style="font-size: 2rem">{{ $payment->payment_code }}</p>
                                            <p class="h5 mb-1">Tanggal Pembayaran</p>
                                            <p class="fw-bold fst-italic text-capitalize" style="font-size: 1rem">{{ \Carbon\Carbon::parse($payment->payment_date)->isoFormat('dddd, D MMMM Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- order sumary --}}
                                <div class="py-2 mt-2">
                                    <div class="table-responsive">
                                        <p class="fst-italic" style="font-size: 1rem">Dengan detail rental sebagai berikut :</p>
                                        <table class="table align-middle nowrap mb-0">
                                            <thead>
                                                <tr class="bg-secondary-slate">
                                                    <th class="text-center">Nama Mobil</th>
                                                    <th class="text-center">Nomor Plat</th>
                                                    <th class="text-center">Metode Pembayaran</th>
                                                    <th class="text-center">Durasi Rental</th>
                                                    <th class="text-center">Tarif per Hari</th>
                                                    <th class="text-left">TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center text-uppercase">{{ $payment->car->name }}</td>
                                                    <td class="text-center text-uppercase">{{ $payment->car->plat }}</td>
                                                    <td class="text-center text-uppercase">{{ $payment->payment_method }}</td>
                                                    <td class="text-center">{{ $payment->duration }} Hari</td>
                                                    <td class="text-center">Rp {{ number_format($payment->car->price, 0, ',','.') }}</td>
                                                    <td class="text-left">Rp {{ number_format($payment->total_price, 0, ',','.') }}</td>
                                                    @php
                                                    //simple tax math
                                                    $vat_tax = 0.1;
                                                    $taxable_payment = $payment->total_price;
                                                    $tax = $vat_tax * $taxable_payment;
                                                    $without_tax = $taxable_payment - $tax;
                                                    @endphp
                                                </tr>
                                                <tfoot>
                                                    <tr class="fw-bold fst-italic">
                                                        <td colspan="3"></td>
                                                        <td colspan="2">Subtotal</td>
                                                        <td class="text-left">Rp {{ number_format($without_tax, 0, ',','.') }}</td>
                                                    </tr>
                                                    <tr class="fw-bold fst-italic">
                                                        <td colspan="3"></td>
                                                        <td colspan="2">Pajak 10%</td>
                                                        <td class="text-left">Rp {{ number_format($tax, 0, ',', '.') }}</td>
                                                    </tr>
                                                    <tr class="fw-bold fst-italic" style="font-size: 1.25rem">
                                                        <td colspan="3"></td>
                                                        <td colspan="2">*Total Pembayaran</td>
                                                        <td class="text-left">Rp {{ number_format($taxable_payment, 0, ',', '.') }}</td>
                                                    </tr>
                                                </tfoot>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                {{-- footer --}}
                                <div class="mt-5 mb-5">
                                    <div class="fw-bold p-2" style="border-left: 10px solid #85bde8;">
                                        <p class="fst-italic mb-0">NB:</p>
                                        <p class="fst-italic">*Harga Rental Kendaraan Sudah Termasuk Pajak PPH dan PPN Sebesar 10%</p>
                                    </div>
                                </div>
                                {{-- sign --}}
                                <div class="row mt-5">
                                    <div class="col-sm-6">
                                        <div class="text-center">
                                            <p class="fw-bold">Hormat Kami,</p>
                                            <br><br><br>
                                            <p class="fw-bold text-capitalize" style="font-size: 1.25rem">{{ auth()->user()->name; }}</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="text-center">
                                            <p class="fw-bold mb-28">Penyewa,</p>
                                            <br><br><br>
                                            <p class="fw-bold text-capitalize" style="font-size: 1.25rem">{{ $payment->user->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <div class="row fst-italic">
                                    <footer class="text-center text-muted" style="font-size: 0.75rem;">
                                        Nota Dicetak Otomatis pada Hari {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }} Pukul {{ Carbon\Carbon::now()->isoFormat('HH:mm:ss') }}
                                    </footer>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')

{{-- script cetak receipt --}}
<script type="text/javascript">
    function printReceipt() {
        var printContents = document.getElementById('print_receipt').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
@endpush
@endsection