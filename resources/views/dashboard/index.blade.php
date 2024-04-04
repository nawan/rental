@push('style')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- bootstrap@5.3.0-alpha3 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/bootstrap-5/css/bootstrap5.min.css') }}" />
{{-- sweet alert2 css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/sweet-alert/css/sweetalert2.min.css') }}" />
{{-- fontawesome css --}}
<link rel="stylesheet" href="{{ URL::asset('assets/fontawesome/css/fontawesome.min.css') }}">
{{-- <link rel="stylesheet" href="{{ URL::asset('assets/toastr/css/toastr.min.css') }}" /> --}}
<style>
    .card-hover:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
    }
    .card-icon {
        color: gray;
    }
    .icon-flipped {
        transform: scaleX(-1);
        -moz-transform: scaleX(-1);
        -webkit-transform: scaleX(-1);
        -ms-transform: scaleX(-1);
}
</style>
@endpush

@push('script')
{{-- sweet alert2 js --}}
<script type="text/javascript" src="{{ URL::asset('assets/sweet-alert/js/sweetalert2.all.min.js') }}"></script>
{{-- sweet alert js --}}
<script type="text/javascript" src="{{ URL::asset('assets/sweet-alert/js/sweetalert.min.js') }}"></script>
{{-- jquery jscript --}}
<script type="text/javascript" src="{{ URL::asset('assets/jquery/jquery-3.6.4.slim.js') }}"></script>
{{-- fontawesome script --}}
<script type="text/javascript" src="{{ URL::asset('assets/fontawesome/js/fontawesome.min.js') }}"></script>
{{-- bootstrap@5.3.0-alpha3 jscript --}}
<script type="text/javascript" src="{{ URL::asset('assets/bootstrap-5/js/bootstrap4.bundle.min.js') }}"></script>
{{-- highchart js --}}
<script type="text/javascript" src="{{ URL::asset('assets/highcharts/npm/charts.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/highcharts/highcharts.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/highcharts/exporting.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/highcharts/export-data.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/highcharts/accessibility.js') }}"></script>

<script type="text/javascript">

        var labels =  {{ Js::from($labels) }};
        var users =  {{ Js::from($data) }};

    Highcharts.chart('dataBooking', {
        title : {
            text : 'Data Booking Mobil Tahun 2023'
        },
        xAxis : {
            // categories: ['April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September','Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret'],
            categories:labels
        },
        yAxis : {
            title : {
                text : 'Dalam Satuan Unit'
            }
        },
        plotOptions : {
            series: {
                allowPointSelect: true
            }
        },
        series :  [
            {
                name:'Jumlah Mobil Terpakai',
                data: users,
                type: 'line'
            }
        ]
    });
</script>
<script type="text/javascript">

    var total_payment = {{ Js::from($data_payment) }};
    var bulan_payment = {{ Js::from($month_payment) }};

    Highcharts.chart('totalCashCollected', {
        title : {
            text : 'Grafik Cash Collected Tahun 2023'
        },
        xAxis : {
            // categories: ['April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September','Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret'],
            categories:bulan_payment
        },
        yAxis : {
            title : {
                text : 'Dalam Satuan Juta'
            }
        },
        plotOptions : {
            series: {
                allowPointSelect: true
            }
        },
        series :  [
            {
                name:'Nominal Cash Collected',
                data: total_payment,
                type: 'column'
            }
        ]
    });
</script>
<script type="text/javascript">
    var total_loan = {{ Js::from($data_loan) }};
    var bulan_loan = {{ Js::from($month_loan) }};

    Highcharts.chart('totalPiutang', {
        title : {
            text : 'Grafik Piutang Tahun 2023'
        },
        xAxis : {
            // categories: ['April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September','Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret'],
            categories: bulan_loan
        },
        yAxis : {
            title : {
                text : 'Dalam Satuan Juta'
            }
        },
        plotOptions : {
            series: {
                allowPointSelect: true
            }
        },
        series :  [
            {
                name:'Nominal Piutang',
                data: total_loan,
                type: 'column'
            }
        ]
    });
</script>
<script type="text/javascript">

    var total = {{ Js::from($data_total) }};
    var bulan = {{ Js::from($month_total) }};

    Highcharts.chart('totalTransaksi', {
        title : {
            text : 'Grafik Revenue Tahun 2023'
        },
        xAxis : {
            // categories: ['April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September','Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret'],
            categories:bulan
        },
        yAxis : {
            title : {
                text : 'Dalam Satuan Juta'
            }
        },
        plotOptions : {
            series: {
                allowPointSelect: true
            }
        },
        series :  [
            {
                name:'Nominal Revenue',
                data: total,
                type: 'area'
            }
        ]
    });
</script>
<script type="text/javascript">
    var avanza = {{ Js::from($avanza) }};
    var mobilio_rs = {{ Js::from($mobilio_rs) }};
    var brio_rs = {{ Js::from($brio_rs) }};
    var xenia = {{ Js::from($xenia) }};
    var luxio = {{ Js::from($luxio) }};
    var innova_reborn = {{ Js::from($innova_reborn) }};
    var innova_zenix = {{ Js::from($innova_zenix) }};
    var grand_innova_diesel = {{ Js::from($grand_innova_diesel) }};
    var ayla = {{ Js::from($ayla) }};
    var agya = {{ Js::from($agya) }};
    var calya = {{ Js::from($calya) }};
    var sigra = {{ Js::from($sigra) }};
    var xpander_cross_matic = {{ Js::from($xpander_cross_matic) }};
    var hiace_premio = {{ Js::from($hiace_premio) }};
    var sirion = {{ Js::from($sirion) }};
    var all_new_jazz = {{ Js::from($all_new_jazz) }};
    var elf_long = {{ Js::from($elf_long) }};

    Highcharts.chart('presentase_mobil',{
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Persentase Mobil Terpakai Tahun 2023',
            align: 'center'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        accessibility: {
            point: {
                valueSuffix: '%'
            }
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }
        },
        series: [{
            name: 'Total:',
            colorByPoint: true,
            data: [{
                name: 'Avanza',
                y: avanza
            },{
                name: 'Mobilio RS',
                y: mobilio_rs
            },{
                name: 'Brio RS',
                y: brio_rs
            },{
                name: 'Xenia',
                y: xenia
            },{
                name: 'Luxio',
                y: luxio
            },{
                name: 'Innova Reborn',
                y: innova_reborn
            },{
                name: 'Innova Zenix',
                y: innova_zenix
            },{
                name: "Grand Innova Diesel",
                y: grand_innova_diesel
            },{
                name: 'Ayla',
                y:ayla
            },{
                name: 'Agya',
                y:6
            },{
                name: 'Calya',
                y: calya
            },{
                name: 'Sigra',
                y: sigra
            },{
                name: 'XPander Cross Matic',
                y:xpander_cross_matic
            },{
                name: 'Hiace Premio 2023',
                y:hiace_premio
            },{
                name: 'Sirion',
                y: sirion
            },{
                name: 'All New Jazz',
                y: all_new_jazz
            },{
                name: 'Elf Long',
                y: elf_long
            }
        ]
        }]
    });
</script>

<script type="text/javascript">
    var total = {{ Js::from($transaksi_total) }};
    var loan = {{ Js::from($transaksi_loan) }};
    var bulan = {{ Js::from($bulan) }};
    var users =  {{ Js::from($data) }};

    var total_payment = {{ Js::from($data_payment) }};
    var bulan_payment = {{ Js::from($month_payment) }};

    var total_loan = {{ Js::from($data_loan) }};
    var bulan_loan = {{ Js::from($month_loan) }};

    var total = {{ Js::from($data_total) }};
    var bulan = {{ Js::from($month_total) }};

    Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    accessibility: {
        description: 'Image description: An area chart compares the nuclear stockpiles of the USA and the USSR/Russia between 1945 and 2017. The number of nuclear weapons is plotted on the Y-axis and the years on the X-axis. The chart is interactive, and the year-on-year stockpile levels can be traced for each country. The US has a stockpile of 6 nuclear weapons at the dawn of the nuclear age in 1945. This number has gradually increased to 369 by 1950 when the USSR enters the arms race with 6 weapons. At this point, the US starts to rapidly build its stockpile culminating in 32,040 warheads by 1966 compared to the USSR’s 7,089. From this peak in 1966, the US stockpile gradually decreases as the USSR’s stockpile expands. By 1978 the USSR has closed the nuclear gap at 25,393. The USSR stockpile continues to grow until it reaches a peak of 45,000 in 1986 compared to the US arsenal of 24,401. From 1986, the nuclear stockpiles of both countries start to fall. By 2000, the numbers have fallen to 10,577 and 21,000 for the US and Russia, respectively. The decreases continue until 2017 at which point the US holds 4,018 weapons compared to Russia’s 4,500.'
    },
    title: {
        text: 'Perbandingan Revenue dan Piutang '
    },
    xAxis : {
            //categories: ['April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September','Oktober', 'November', 'Desember', 'Januari', 'Februari', 'Maret'],
            categories: bulan
        },
    yAxis : {
        title : {
            text : 'Dalam Satuan Juta'
        }
    },
    tooltip: {
        pointFormat: '{series.name} had stockpiled <b>{point.y:,.0f}</b><br/>warheads in {point.x}'
    },
    plotOptions : {
            series: {
                allowPointSelect: true
            }
    },
    series: [{
        name: 'Cash Collected',
        data: total_payment
    }, {
        name: 'Revenue',
        data: total
    }]
});

</script>
@endpush

@extends('layouts.main')

@section('content')
<nav aria-label="breadcrumb" class="navbar navbar-light bg-light mb-4 mt-4">
    <ol class="breadcrumb my-auto p-2">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="mb-2 text-decoration-none"><i class="fas fa-home"></i>  Dashboard</a></li>
    </ol>
</nav>

<div class="row mb-2">
    <div class="col-xl-4 col-md-6">
        <div class="card card-hover bg-primary mb-4">
            <div class="card-body">
                <div class="row align-middle">
                    <div class="col font-bold display-1 text-center text-white">
                        <i class="fa fa-car icon-flipped"></i>
                    </div>
                    <div class="col text-white">
                        <div class="row text-uppercase display-6 fw-bold">
                            {{ $car }}
                        </div>
                        <div class="row text-uppercase">
                            data mobil
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light d-flex align-items-center justify-content-between">
                <a class="small stretched-link" href="{{ route('car.index') }}"><span class="badge bg-primary text-lg text-white">Lihat Data Mobil</span></a>
                <div class="small"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card card-hover bg-danger mb-4">
            {{-- <div class="card-header text-white fw-bold  text-uppercase text-center"><i class="fa fa-users"></i> data pelanggan</div>
            <div class="card-body bg-light text-center fw-bold display-6">{{ $user }} Pelanggan</div> --}}
            <div class="card-body">
                <div class="row align-middle">
                    <div class="col font-bold display-1 text-center text-white">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="col text-white">
                        <div class="row text-uppercase display-6 fw-bold">
                            {{ $user }}
                        </div>
                        <div class="row text-uppercase">
                            data pelanggan
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light d-flex align-items-center justify-content-between">
                <a class="small stretched-link" href="{{ route('user.index') }}"><span class="badge bg-danger text-lg text-white">Lihat Data Pelanggan</span></a>
                <div class="small"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card card-hover bg-success mb-4">
            <div class="card-body">
                <div class="row align-middle">
                    <div class="col font-bold display-1 text-center text-white">
                        <i class="fa fa-calendar-check"></i>
                    </div>
                    <div class="col text-white">
                        <div class="row text-uppercase display-6 fw-bold">
                            {{ $transaction }}
                        </div>
                        <div class="row text-uppercase">
                            data booking
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light d-flex align-items-center justify-content-between">
                <a class="small stretched-link" href="{{ route('transaction.index') }}"><span class="badge bg-success text-lg text-white">Lihat Data Booking</span></a>
                <div class="small"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-xl-6 col-md-6">
        <div class="card card-hover bg-warning mb-4">
            {{-- <div class="card-header text-white fw-bold  text-uppercase text-center"><i class="fa fa-money-bill"></i> total pendapatan</div>
            <div class="card-body bg-light text-center fw-bold display-6">Rp {{ number_format($payment, 0, ',', '.') }}</div> --}}
            <div class="card-body">
                <div class="row align-middle">
                    <div class="col font-bold display-1 text-center text-white">
                        <i class="fa fa-money-check-alt"></i>
                    </div>
                    <div class="col text-white">
                        <div class="row text-uppercase display-6 fw-bold">
                            Rp {{ number_format($payment, 0, ',', '.') }}
                        </div>
                        <div class="row text-uppercase">
                            total pendapatan
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light d-flex align-items-center justify-content-between">
                <a class="small stretched-link" href="{{ route('payment.history') }}"><span class="badge bg-warning text-lg text-white">Lihat Detail Pembayaran</span></a>
                <div class="small"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="card card-hover bg-secondary mb-4">
            {{-- <div class="card-header text-white fw-bold  text-uppercase text-center"><i class="fa fa-file-invoice"></i> total piutang</div>
            <div class="card-body bg-light text-center fw-bold display-6">Rp {{ number_format($piutang, 0, ',', '.') }}</div> --}}
            <div class="card-body">
                <div class="row align-middle">
                    <div class="col font-bold display-1 text-center text-white">
                        <i class="fa fa-file-invoice"></i>
                    </div>
                    <div class="col text-white">
                        <div class="row text-uppercase display-6 fw-bold">
                            Rp {{ number_format($piutang, 0, ',', '.') }}
                        </div>
                        <div class="row text-uppercase">
                            total piutang
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-light d-flex align-items-center justify-content-between">
                <a class="small stretched-link" href="{{ route('payment.index') }}"><span class="badge bg-secondary text-lg text-white">Lihat Data Piutang</span></a>
                <div class="small"><i class="fas fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row mb-2">
    <div class="col-xl-6 col-md-6">
        <div class="card bg-white mb-4">
            <div id="totalTransaksi"></div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="card bg-white mb-4">
            <canvas id="dataBooking"></canvas>
        </div>
    </div>
</div> --}}

<div class="row mb-2">
    <div class="col-xl-12 col-md-6">
        <div class="card mb-4">
            <div class="card bg-white mb-4">
                <div class="card-header text-secondary"><i style="font-size:17px" class="fa">&#xf200;</i> Grafik Mobil Terpakai</div>
                <div class="card-body">
                    <div id="presentase_mobil"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mb-2">
    <div class="col-xl-6 col-md-6">
        <div class="card bg-white mb-4">
            <div class="card-header text-secondary"><i style="font-size:17px" class="fa">&#xf080;</i> Total Cash Collected</div>
            <div class="card-body" id="totalCashCollected"></div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="card bg-white mb-4">
            <div class="card-header text-secondary"><i style="font-size:17px" class="fa">&#xf080;</i> Grafik Total Piutang</div>
            <div class="card-body">
                <div id="totalPiutang"></div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row mb-2">
    <div class="col-xl-12 col-md-6">
        <div class="card mb-4">
            <div class="card-body">
                <div id="container"></div>
            </div>
        </div>
    </div>
</div> --}}

{{-- <div class="row mb-2">
    <div class="col-xl-6 col-md-6">
        <div class="card bg-white mb-4">
            <div class="card-header text-secondary"><i style="font-size:17px" class="fa">&#xf200;</i> Grafik Mobil Terpakai</div>
            <div class="card-body">
                <div id="presentase_mobil"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="card bg-white mb-4">
            <div class="card-header text-secondary"><i style="font-size:17px" class="fa">&#xf201;</i> Grafik Data Booking</div>
            <div class="card-body">
                <div id="dataBooking"></div>
            </div>
        </div>
    </div>
</div> --}}


{{-- <div class="row mt-10 mb-2">
    <div class="col-md-12 col-xl-12">
        <div class="card bg-white mb-4">
            <canvas id=""></canvas>
        </div>
    </div>
</div> --}}
@endsection