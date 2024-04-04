<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
use App\Models\Transaction;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use DateTime;

class UsedCarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaction::where('status', '=', 'APPROVED')
                ->orWhere('status', '=', 'PAID')
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
                ->editColumn('duration', function (Transaction $transaction) {
                    $date_start = new DateTime($transaction->date_start);
                    $date_end = new DateTime($transaction->date_end);
                    $diff = $date_start->diff($date_end);
                    $duration = $diff->days + 1;
                    return $duration;
                })
                ->editColumn('car_status', function (Transaction $transaction) {
                    $transaction = Transaction::with('car')->find($transaction->id);
                    if ($transaction->car->status == 0) {
                        return 'Terpakai';
                    } else
                        return 'Tersedia';
                })
                ->editColumn('payment_status', function (Transaction $transaction) {
                    return $transaction->status;
                })
                ->addColumn('action', function (Transaction $transaction) {
                    $btn = '<form class="d-inline" action=' . route("usedcar.status", $transaction->id) . ' method="POST">
                    <input type="hidden" name="_token" value=' . csrf_token() . '>
                    <input type="hidden" name="status">
                    <button class="btn btn-primary btn-sm" type="submit" title="Proses Kembali" data-toggle="tooltip" data-placement="top"><i class="fa fa-car"></i> Kembali</button>
                    </form>';
                    $encryptID = Crypt::encrypt($transaction->id);
                    $btn = $btn . '<a href=' . route("transaction.show", $encryptID) . ' class="btn btn-info btn-sm" title="Detail Booking" data-toggle="tooltip" data-placement="top"><i class="fa fa-info-circle"></i> Detail Booking</a>';
                    return $btn;
                })

                ->rawColumns(['action', 'modal'])
                ->make(true);
        }
        return view('usedcars.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Transaction $transaction)
    {
        // $decryptID = Crypt::decrypt($id);
        // $transaction = Transaction::find($decryptID)->with('user', 'car');
        $transaction = Transaction::with('user', 'car')->find($transaction->id);
        return view('usedcars.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        // $users = User::all();
        // $cars = Car::all();
        // return view('transaction.edit', compact('users', 'cars', 'transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        // Transaction::destroy($transaction->id);
        // return redirect()->route('transaction.index')->with('success', 'Transaksi rental berhasil dihapus !');
    }

    public function status(Request $request, Transaction $transaction, Car $car)
    {
        if ($transaction->status == 'PAID') {
            $transaction->update([
                'status' => 'DONE'
            ]);
            $transaction = Transaction::with('car')->find($transaction->id);
            $transaction->car->status = '1';
            $transaction->car->save();

            return redirect()->route('transaction.record')->with('message', 'Transaksi selesai, mobil telah kembali ke garasi!');
        } else {
            $transaction->update([
                'status' => 'RETURNED'
            ]);
            $transaction = Transaction::with('car')->find($transaction->id);
            $transaction->car->status = '1';
            $transaction->car->save();

            return redirect()->route('payment.index')->with('message', 'Transaksi selesai, mobil telah kembali ke garasi!');
        }
    }
}
