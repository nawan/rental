<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Payment;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Crypt;
use DateTime;
use Illuminate\Support\Carbon;

class CetakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function surat_jalan(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaction::where('status', '=', 'APPROVED')
                ->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('car_id', function (Transaction $transaction) {
                    $transaction = Transaction::with('car')->find($transaction->id);
                    return $transaction->car->name;
                })
                ->editColumn('plat', function (Transaction $transaction) {
                    $transaction = Transaction::with('car')->find($transaction->id);
                    return $transaction->car->plat;
                })
                ->editColumn('user_id', function (Transaction $transaction) {
                    $transaction = Transaction::with('user')->find($transaction->id);
                    return $transaction->user->name;
                })
                ->editColumn('alamat', function (Transaction $transaction) {
                    $transaction = Transaction::with('user')->find($transaction->id);
                    return $transaction->user->alamat;
                })
                ->editColumn('duration', function (Transaction $transaction) {
                    $date_start = new DateTime($transaction->date_start);
                    $date_end = new DateTime($transaction->date_end);
                    $diff = $date_start->diff($date_end);
                    $duration = $diff->days + 1;
                    return $duration;
                })
                ->editColumn('total', function (Transaction $transaction) {
                    return number_format($transaction->total, 0, ',', '.');
                })
                ->editColumn('tujuan', function (Transaction $transaction) {
                    return $transaction->note;
                })
                ->addColumn('action', function (Transaction $transaction) {
                    $btn = '<a href=' . route("transaction.show", $transaction->id) . ' class="btn btn-info btn-sm" title="Cetak Surat Jalan" data-toggle="tooltip" data-placement="top"><i class="fa fa-print"></i> Cetak</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'modal'])
                ->make(true);
        }
        return view('cetak.suratjalan');
    }

    public function bukti_bayar(Request $request)
    {
        $payment = Payment::all();
        // $transaction = Transaction::all();
        if ($request->ajax()) {
            // $data = Transaction::latest()->get();
            $data = Payment::where('payment_status', '=', 'LUNAS')
                ->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('user_id', function (Payment $payment) {
                    $payment = Payment::with('user')->find($payment->id);
                    return $payment->user->name;
                })
                ->editColumn('car_id', function (Payment $payment) {
                    $payment = Payment::with('car')->find($payment->id);
                    return $payment->car->name;
                })
                ->editColumn('total_price', function (Payment $payment) {
                    return number_format($payment->total_price, 0, ',', '.');
                })
                ->editColumn('payment_status', function (Payment $payment) {
                    return $payment->payment_status;
                })
                ->editColumn('payment_method', function (Payment $payment) {
                    return $payment->payment_method;
                })
                ->editColumn('payment_date', function (Payment $payment) {
                    return Carbon::parse($payment->payment_date)->isoFormat('D MMMM Y');
                })
                ->addColumn('action', function (Payment $payment) {
                    $encryptID = Crypt::encrypt($payment->id);
                    $btn = '<a href=' . route("receipt", $encryptID) . ' class="btn btn-primary btn-sm m-1" title="Lihat Pembayaran" data-toggle="tooltip" data-placement="top"><i class="fa fa-print"></i> Cetak</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'modal'])
                ->make(true);
        }
        return view('cetak.buktibayar', compact('payment'));
    }

    public function receipt($id, Payment $payment)
    {
        $decryptID = Crypt::decrypt($id);

        $payment = Payment::find($decryptID);
        // $cars = Car::all();
        // $users = User::all();
        // $transactions = Transaction::all();

        return view('cetak.receipt', compact('payment'));
    }

    public function cetakreceipt($id, Payment $payment)
    {
        $decryptID = Crypt::decrypt($id);

        $payment = Payment::find($decryptID);

        return view('cetak.cetakreceipt', compact('payment'));
    }
}
