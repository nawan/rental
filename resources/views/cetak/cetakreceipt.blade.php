<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Payment Receipt</title>
        {{-- bootstrap@5.3.0-alpha3 css --}}
        <link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/bootstrap.min.css') }}" />
        {{-- sweet alert2 css --}}
        <link rel="stylesheet" href="{{ URL::asset('assets/sweet-alert/css/sweetalert2.min.css') }}" />
        <style>@media print{@page {size: A4 potrait}}
        
        </style>
    </head>
    <body>
                <div class="col-lg-12">
                    <div class="card" id="print_receipt">
                        <div class="card-body">
                            {{-- company title receipt --}}
                            <div class="invoice-title">
                                <div class="mb-2">
                                    <img src="{{ URL::asset('/assets/img/logo-blue.png') }}" class="navbar-brand-img" data-holder-rendered="true" height="auto" width="100px" />
                                </div>
                                <div class="text-muted" style="font-size: 0.75rem">
                                    <p class="mb-0">Jl Parangtritis KM 5 Pendowoharjo Sewon Bantul</p>
                                    <p class="mb-1"><i class="fa fa-home"></i> <a href="https://nawan.vercel.app/" target="_blank">www.nawansite.com</a></p>
                                    <p class="mb-1"><i class="fa fa-envelope"></i> rental@nawansite.com</p>
                                    <p class="mb-1"> <i class="fa fa-phone"></i> 081222333444</p>
                                    {{-- <p class="mb-0"><i class="fa fa-home"></i> <a href="https://nawan.vercel.app/" target="_blank">www.nawansite.com</a></p> --}}
                                    {{-- <p class="mb-0"><i class="fa fa-envelope"></i> rental@nawansite.com</p>
                                    <p class="mb-0"> <i class="fa fa-phone"></i> 081222333444</p> --}}
                                </div>
                            </div>
                            <hr class="my-2">
                            {{-- client title receipt --}}
                            <div class="row">
                                {{-- col 1 --}}
                                <div class="col-sm-6" style="font-size: 0.75rem">
                                    <div class="text-muted text-start">
                                        <p class="h5 mb-1">Telah diterima pembayaran rental dari :</p>
                                        <p class="mb-0 fw-bold text-capitalize" style="font-size: 1rem"> {{ $payment->user->name }}</p>
                                        <p class="mb-0">{{ $payment->user->no_kontak }}</p>
                                        <p class="mb-0 text-capitalize" style="font-size: 1rem">{{ $payment->user->alamat }}</p>
                                    </div>
                                </div>
                                {{-- col 2 --}}
                                <div class="col-sm-6" style="font-size: 0.75rem">
                                    <div class="text-end">
                                        <p class="h6 mb-1 fw-bold">Kode Pembayaran</p>
                                        <p class="fst-italic text-uppercase text-muted mb-2" style="font-size: 1rem">{{ $payment->payment_code }}</p>
                                        <p class="h6 mb-1 fw-bold">Tanggal Pembayaran</p>
                                        <p class="fst-italic text-capitalize text-muted" style="font-size: 1rem">{{ \Carbon\Carbon::parse($payment->created_at)->isoFormat('dddd, D MMMM Y') }}</p>
                                    </div>
                                </div>
                            </div>
                            {{-- order sumary --}}
                            <div class="py-2">
                                <div class="table-responsive" style="font-size: 0.8rem">
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
                                                <tr class="fw-bold fst-italic" style="font-size: 1rem">
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
                            <div class="mt-1" style="font-size: 0.8rem">
                                <div class="fw-bold p-2" style="border-left: 10px solid #85bde8;">
                                    <p class="fst-italic mb-0" style="font-size: 0.75rem">NB:</p>
                                    <p class="fst-italic" style="font-size: 1rem">*Harga Rental Kendaraan Sudah Termasuk Pajak PPH dan PPN Sebesar 10%</p>
                                </div>
                            </div>
                            {{-- sign --}}
                            <div class="row mt-1" style="font-size: 0.8rem">
                                <div class="col-sm-6">
                                    <div class="text-center">
                                        <p class="fw-bold">Hormat Kami,</p>
                                        <br><br>
                                        <p class="fw-bold text-capitalize" style="font-size: 1rem">{{ auth()->user()->name; }}</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-center">
                                        <p class="fw-bold">Penyewa,</p>
                                        <br><br>
                                        <p class="fw-bold text-capitalize" style="font-size: 1rem">{{ $payment->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-1">
                            <div class="row fst-italic">
                                <footer class="text-muted text-end" style="font-size: 0.75rem;">
                                    Nota Dicetak Otomatis pada Hari {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }} Pukul {{ Carbon\Carbon::now()->isoFormat('HH:mm:ss') }}
                                </footer>
                            </div>
                        </div>
                    </div>
                </div>
        <script>
            window.print();
        </script>
    </body>
    @stack('script')
</html>