<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //jumlah data mobil
        $car = Car::count();

        //jumlah data user selain admin
        $user = User::where('is_admin', '!=', 1)->count();

        //jumlah data transaksi
        $transaction = Transaction::where('status', '=', 'PENDING')
            ->orWhere('status', '=', 'CANCELED')
            ->orWhere('status', '=', 'APPROVED')
            ->count();

        //jumlah total pembayaran atau pendapatan
        $payment = Payment::sum('total_price');

        //jumlah data rental yang belum dibayar
        $piutang = Transaction::where('status', '=', 'APPROVED')
            ->orWhere('status', '=', 'RETURNED')
            ->sum('total');

        //grafik jumlah booking mobil
        $booking = Transaction::select(DB::raw("COUNT(*) as count"), DB::raw("MONTHNAME(created_at) as month_name"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('count', 'month_name');
        $labels = $booking->keys();
        $data = $booking->values();
        // dd($data);

        $transaksi_total = Transaction::select(DB::raw("CAST(SUM(total) as int) as total"), DB::raw("MONTHNAME(created_at) as month_total"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('total', 'month_total');
        $month_total = $transaksi_total->keys();
        $data_total = $transaksi_total->values();
        //dd($transaksi_total);

        $transaksi_loan = Transaction::select(DB::raw("CAST(SUM(total) as int) as loan"), DB::raw("MONTHNAME(created_at) as month_loan"))
            ->where('status', '=', 'APPROVED')
            ->orWhere('status', '=', 'RETURNED')
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('loan', 'month_loan');
        $month_loan = $transaksi_loan->keys();
        $data_loan = $transaksi_loan->values();
        //dd($transaksi_loan);

        $payment_total = Payment::select(DB::raw("CAST(SUM(total_price) as int) as payment"), DB::raw("MONTHNAME(payment_date) as month_payment"))
            ->groupBy(DB::raw("MONTHNAME(payment_date)"))
            ->pluck('payment', 'month_payment');
        $month_payment = $payment_total->keys();
        $data_payment = $payment_total->values();
        // dd($payment_total);

        //menghitung avanza pada tabel transaksi
        $avanza = Transaction::where('car_id', '=', 1)
            ->count();

        //menghitung mobilio_rs pada tabel transaksi
        $mobilio_rs = Transaction::where('car_id', '=', 3)
            ->count();

        //menghitung brio rs pada tabel transaksi
        $brio_rs = Transaction::where('car_id', '=', 4)
            ->count();

        //menghitung xenia pada tabel transaksi
        $xenia = Transaction::where('car_id', '=', 5)
            ->count();

        //menghitung luxio pada tabel transaksi
        $luxio = Transaction::where('car_id', '=', 6)
            ->count();

        //menghitung innova reborn pada tabel transaksi
        $innova_reborn = Transaction::where('car_id', '=', 7)
            ->count();

        //menghitung innova zenix pada tabel transaksi
        $innova_zenix = Transaction::where('car_id', '=', 8)
            ->count();

        //menghitung grand innova diesel pada tabel transaksi
        $grand_innova_diesel = Transaction::where('car_id', '=', 9)
            ->count();

        //menghitung ayla pada tabel transaksi
        $ayla = Transaction::where('car_id', '=', 10)
            ->count();

        //menghitung agya pada tabel transaksi
        $agya = Transaction::where('car_id', '=', 11)
            ->count();

        //menghitung calya pada tabel transaksi
        $calya = Transaction::where('car_id', '=', 12)
            ->count();

        //menghitung sigra pada tabel transaksi
        $sigra = Transaction::where('car_id', '=', 13)
            ->count();

        //menghitung xpander crosss matic pada tabel transaksi
        $xpander_cross_matic = Transaction::where('car_id', '=', 14)
            ->count();

        //menghitung hiace premio pada tabel transaksi
        $hiace_premio = Transaction::where('car_id', '=', 15)
            ->count();

        //menghitung sirion pada tabel transaksi
        $sirion = Transaction::where('car_id', '=', 30)
            ->count();

        //menghitung all new jazz 2020 pada tabel transaksi
        $all_new_jazz = Transaction::where('car_id', '=', 31)
            ->count();

        //menghitung elf long 17 seat pada tabel transaksi
        $elf_long = Transaction::where('car_id', '=', 32)
            ->count();
        // dd($elf_long);

        $bulan = Transaction::select(DB::raw("MONTHNAME(created_at) as bulan"))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw("MONTHNAME(created_at)"))
            ->pluck('bulan');
        // dd($bulan);



        return view('dashboard.index', compact(
            'car',
            'user',
            'transaction',
            'payment',
            'piutang',
            'labels',
            'data',
            'month_total',
            'data_total',
            'month_loan',
            'data_loan',
            'month_payment',
            'data_payment',
            'transaksi_total',
            'transaksi_loan',
            'bulan',
            'avanza',
            'mobilio_rs',
            'brio_rs',
            'xenia',
            'luxio',
            'innova_reborn',
            'innova_zenix',
            'grand_innova_diesel',
            'ayla',
            'agya',
            'calya',
            'sigra',
            'xpander_cross_matic',
            'hiace_premio',
            'sirion',
            'all_new_jazz',
            'elf_long'
        ));
    }
}
