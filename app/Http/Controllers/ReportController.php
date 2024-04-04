<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    public function report_car(Request $request)
    {
        if ($request->ajax()) {
            $data = Car::latest()
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (Car $car) {
                    return $car->name;
                })
                ->editColumn('image', function (Car $car) {
                    return $car->image;
                })
                ->editColumn('plat', function (Car $car) {
                    return $car->plat;
                })
                ->editColumn('price', function (Car $car) {
                    return number_format($car->price, 0, ',', '.');
                })
                ->editColumn('status', function (Car $car) {
                    return $car->status;
                })
                ->editColumn('description', function (Car $car) {
                    return $car->description;
                })
                ->make(true);
        }

        return view('report.laporan-mobil');
    }

    public function report_pelanggan(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaction::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function (Transaction $transaction) {
                    return $transaction->user->name;
                })
                ->editColumn('nik', function (Transaction $transaction) {
                    return $transaction->user->nik;
                })
                ->editColumn('ktp', function (Transaction $transaction) {
                    return $transaction->user->image;
                })
                ->editColumn('no_kontak', function (Transaction $transaction) {
                    return $transaction->user->no_kontak;
                })
                ->editColumn('email', function (Transaction $transaction) {
                    return $transaction->user->email;
                })
                ->editColumn('alamat', function (Transaction $transaction) {
                    return $transaction->user->alamat;
                })
                ->editColumn('created_at', function (Transaction $transaction) {
                    return Carbon::parse($transaction->user->created_at)->isoFormat('D MMMM Y');
                })
                ->make(true);
        }
        return view('report.laporan-pelanggan');

        // if ($request->ajax()) {
        //     $data = User::latest()->get();
        //     return DataTables::of($data)
        //         ->addIndexColumn()
        //         ->editColumn('name', function (User $user) {
        //             return $user->name;
        //         })

        //         ->make(true);
        // }
        // return view('report.laporan-pelanggan');


        // if ($request->ajax()) {
        //     $users = User::where('is_admin', '=', 0)
        //         ->latest()
        //         ->get();
        //     return DataTables::of($users)
        //         ->addIndexColumn()
        //         ->editColumn('name', function (User $user) {
        //             return $user->name;
        //         })
        //         ->editColumn('nik', function (User $user) {
        //             return $user->nik;
        //         })
        //         ->editColumn('ktp', function (User $user) {
        //             return $user->image;
        //         })
        //         ->editColumn('no_kontak', function (User $user) {
        //             return $user->no_kontak;
        //         })
        //         ->editColumn('email', function (User $user) {
        //             return $user->email;
        //         })
        //         ->editColumn('alamat', function (User $user) {
        //             return $user->alamat;
        //         })
        //         ->editColumn('created_at', function (User $user) {
        //             return Carbon::parse($user->created_at)->isoFormat('D MMMM Y');
        //         })
        //         ->make(true);
        // }
        // return view('report.laporan-pelanggan');
    }

    public function report_pembayaran(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaction::latest()
                ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('user_id', function (Transaction $transaction) {
                    return $transaction->user->name;
                })
                ->editColumn('car_id', function (Transaction $transaction) {
                    return $transaction->car->name;
                })
                ->editColumn('plat', function (Transaction $transaction) {
                    return $transaction->car->plat;
                })
                ->editColumn('duration', function (Transaction $transaction) {
                    $tgl_sewa = new DateTime($transaction->date_start);
                    $tgl_kembali = new DateTime($transaction->date_end);
                    $duration = $tgl_sewa->diff($tgl_kembali);
                    return $duration->days + 1;
                })
                ->editColumn('total', function (Transaction $transaction) {
                    return number_format($transaction->total, 0, ',', '.');
                })
                ->editColumn('status', function (Transaction $transaction) {
                    return $transaction->status;
                })
                ->make(true);
        }
        return view('report.laporan-pembayaran');
    }
}
