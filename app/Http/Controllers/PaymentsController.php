<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Car;
use App\Models\UserDetail;
use DateTime;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transaction = Transaction::all();
        if ($request->ajax()) {
            // $data = Transaction::latest()->get();
            $data = Transaction::where('status', '=', 'APPROVED')
                ->orWhere('status', '=', 'RETURNED')
                ->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('user_id', function (Transaction $transaction) {
                    $transaction = Transaction::with('user')->find($transaction->id);
                    return $transaction->user->name;
                })
                ->editColumn('car_id', function (Transaction $transaction) {
                    $transaction = Transaction::with('car')->find($transaction->id);
                    return $transaction->car->name;
                })
                ->editColumn('date_start', function (Transaction $transaction) {
                    return Carbon::parse($transaction->date_start)->isoFormat('D MMMM Y');
                })
                ->editColumn('date_end', function (Transaction $transaction) {
                    return Carbon::parse($transaction->date_end)->isoFormat('D MMMM Y');
                })
                ->editColumn('status', function (Transaction $transaction) {
                    return $transaction->status;
                })
                ->editColumn('total', function (Transaction $transaction) {
                    return number_format($transaction->total, 0, ',', '.');
                })
                ->addColumn('action', function (Transaction $transaction) {
                    $encryptID = Crypt::encrypt($transaction->id);

                    // $btn = '<a href=' . route("transaction.edit", $encryptID) . ' class="edit btn btn-warning btn-sm m-1" title="Edit Transaksi" data-toggle="tooltip" data-placement="top"><i class="fas fa-edit"></i></a>';
                    // $btn = $btn . '<a href=' . route("transaction.show", $encryptID) . ' class="btn btn-info btn-sm m-1" title="Lihat Transaksi" data-toggle="tooltip" data-placement="top"><i class="fas fa-eye"></i></a>';
                    $btn =  '<a href=' . route("payment.pay", $encryptID) . ' class="btn btn-primary btn-sm m-1" title="Lihat Transaksi" data-toggle="tooltip" data-placement="top"><i class="fas fa-money-check-alt"></i> Bayar</a>';

                    // $btn = '<a href=' . route("availablecar.booking", $car->id) . ' class="btn btn-primary btn-sm" title="Booking" data-toggle="tooltip" data-placement="top"><i class="fa fa-plus-square"></i> Booking</a>';
                    // $btn = $btn . '<form class="d-inline m-1" action=' . route("transaction.approve", $transaction->id) . ' method="POST">
                    //     <input type="hidden" name="_token" value=' . csrf_token() . '>
                    //     <input type="hidden" name="status" value="APPROVED">
                    //     <button class="btn btn-outline-success btn-sm" title="Approve Booking" data-toggle="tooltip" data-placement="top" type="submit"><i class="far fa-check-circle"></i></button>
                    //     </form>';
                    // $btn = $btn . '<form class="d-inline m-1" title="Cancel Booking" data-toggle="tooltip" data-placement="top" action=' . route("transaction.cancel", $transaction->id) . ' method="POST">
                    //     <input type="hidden" name="_token" value=' . csrf_token() . '>
                    //     <input type="hidden" name="status" value="CANCELED">
                    //     <button class="btn btn-outline-danger btn-sm" type="submit"><i class="far fa-times-circle"></i></button>
                    //     </form>';
                    return $btn;
                })

                ->rawColumns(['action', 'modal'])
                ->make(true);
        }
        return view('payment.index', compact('transaction'));
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
        $data = $request->validate([
            'user_id' => 'required',
            'car_id' => 'required',
            'transaction_id' => 'required',
            'total_price' => 'required',
            'duration' => 'required',
            'payment_method' => 'required|not_in:0',
            'payment_code' => 'required',
            'payment_date' => 'required',
            'created_by' => 'required',
        ]);
        if ($request->file('image')) {
            $data['payment_proof'] = $request->file('image')->store('payments');
        }

        $data['payment_status'] = 'LUNAS';
        $transaction = Transaction::find($request->transaction_id);
        // $car = Car::find($request->car_id);
        // $date_start = new DateTime($request->date_start);
        // $date_end = new DateTime($request->date_end);
        // $duration = $date_start->diff($date_end);
        // $data['total'] = $car->price * ($duration->days + 1);
        if ($transaction->status == 'RETURNED') {
            Payment::create($data);
            $transaction->status = 'DONE';
            $transaction->save();
        } else {
            Payment::create($data);
            $transaction->status = 'PAID';
            $transaction->save();
        }

        return redirect()->route('payment.history')->with('message', 'Pembayaran rental mobil berhasil dilakukan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $decryptID = Crypt::decrypt($id);

        $payment = Payment::find($decryptID);

        return view('payment.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Transaction $transaction)
    {
        $decryptID = Crypt::decrypt($id);

        $payment = Payment::find($decryptID);
        $transactions =  Transaction::all();

        $price = number_format($payment->total_price, 0);

        return view('payment.edit', compact('payment', 'transactions', 'price'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $data = $request->validate([
            'payment_method' => 'required|not_in:0',
            'payment_date' => 'required',
        ]);
        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $data['payment_proof'] = $request->file('image')->store('payments');
        }
        $payment->update($data);
        return redirect()->route('payment.history')->with('message', 'Data Pembayaran Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        if ($payment->payment_proof) {
            Storage::delete($payment->payment_proof);
        }
        Payment::destroy($payment->id);
        return redirect()->route('payment.history');
    }

    public function pay($id, Transaction $transaction, Request $request)
    {
        $decryptID = Crypt::decrypt($id);

        $transaction = Transaction::with('user', 'car')->find($decryptID);
        // $transaction = Transaction::find($id);

        $date_start = new DateTime($transaction->date_start);
        $date_end = new DateTime($transaction->date_end);
        $diff = $date_start->diff($date_end);
        $duration = $diff->days + 1;

        $price = number_format($transaction->total, 0);

        $users = User::find($request->user_id);
        $cars = Car::all();
        return view('payment.pay', compact('users', 'cars', 'transaction', 'duration', 'price'));
    }

    public function history(Request $request)
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
                    if (auth()->user()->name == 'nawan') {
                        $btn = '<form class="d-inline m-1" action=' . route("payment.destroy", $payment->id) . ' method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value=' . csrf_token() . '>
                        <button class="btn btn-danger btn-sm btn-flat" type="submit" title="Hapus Pembayaran" data-toggle="tooltip" data-placement="top" onclick="deleteConfirm(event)"><i class="fas fa-trash"></i></button>
                        </form>';
                        $btn = $btn . '<a href=' . route("payment.edit", $encryptID) . ' class="edit btn btn-warning btn-sm m-1" title="Edit Pembayaran" data-toggle="tooltip" data-placement="top"><i class="fas fa-edit"></i></a>';
                        $btn = $btn . '<a href=' . route("payment.show", $encryptID) . ' class="btn btn-info btn-sm m-1" title="Lihat Pembayaran" data-toggle="tooltip" data-placement="top"><i class="fas fa-eye"></i></a>';
                    } else {
                        $btn = '<a href=' . route("payment.show", $encryptID) . ' class="btn btn-info btn-sm m-1" title="Lihat Pembayaran" data-toggle="tooltip" data-placement="top"><i class="fas fa-eye"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action', 'modal'])
                ->make(true);
        }
        return view('payment.history', compact('payment'));
    }
}
