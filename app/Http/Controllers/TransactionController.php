<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use DateTime;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Blade;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$transaction = Transaction::all();
        if ($request->ajax()) {
            // $data = Transaction::latest()->get();
            $data = Transaction::where('status', '=', 'PENDING')
                ->orWhere('status', '=', 'CANCELED')
                ->orWhere('status', '=', 'APPROVED')
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
                    if ($transaction->car->status == 1) {
                        $btn = '<a href=' . route("transaction.edit", $encryptID) . ' class="edit btn btn-warning btn-sm m-1" title="Edit Transaksi" data-toggle="tooltip" data-placement="top"><i class="fas fa-edit"></i></a>';
                        $btn = $btn . '<a href=' . route("transaction.show", $encryptID) . ' class="btn btn-info btn-sm m-1" title="Lihat Transaksi" data-toggle="tooltip" data-placement="top"><i class="fas fa-eye"></i></a>';
                        $btn = $btn . '<form class="d-inline m-1" action=' . route("transaction.approve", $transaction->id) . ' method="POST">
                        <input type="hidden" name="_token" value=' . csrf_token() . '>
                        <input type="hidden" name="status" value="APPROVED">
                        <button class="btn btn-outline-success btn-sm" title="Approve Booking" data-toggle="tooltip" data-placement="top" type="submit"><i class="far fa-check-circle"></i></button>
                        </form>';
                        $btn = $btn . '<form class="d-inline m-1" title="Cancel Booking" data-toggle="tooltip" data-placement="top" action=' . route("transaction.cancel", $transaction->id) . ' method="POST">
                        <input type="hidden" name="_token" value=' . csrf_token() . '>
                        <input type="hidden" name="status" value="CANCELED">
                        <button class="btn btn-outline-danger btn-sm" type="submit"><i class="far fa-times-circle"></i></button>
                        </form>';
                    } elseif ($transaction->status == 'APPROVED') {
                        $btn = '<a href=' . route("transaction.show", $encryptID) . ' class="btn btn-info btn-sm m-1" title="Lihat Transaksi" data-toggle="tooltip" data-placement="top"><i class="fas fa-eye"></i></a>';
                        $btn = $btn . '<form class="d-inline m-1" title="Cancel Booking" data-toggle="tooltip" data-placement="top" action=' . route("transaction.cancel", $transaction->id) . ' method="POST">
                        <input type="hidden" name="_token" value=' . csrf_token() . '>
                        <input type="hidden" name="status" value="CANCELED">
                        <button class="btn btn-outline-danger btn-sm" type="submit"><i class="far fa-times-circle"></i></button>
                        </form>';
                    } elseif ($transaction->status == 'CANCELED') {
                        $btn = '<a href=' . route("transaction.show", $encryptID) . ' class="btn btn-info btn-sm m-1" title="Lihat Transaksi" data-toggle="tooltip" data-placement="top"><i class="fas fa-eye"></i></a>';
                        $btn = $btn . '<form class="d-inline m-1" action=' . route("transaction.destroy", $transaction->id) . ' method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value=' . csrf_token() . '>
                        <button class="btn btn-danger btn-sm btn-flat" type="submit" title="Hapus Transaksi" data-toggle="tooltip" data-placement="top" onclick="deleteConfirm(event)"><i class="fas fa-trash"></i></button>
                        </form>';
                    } else {
                        $btn = '<a href=' . route("transaction.edit", $encryptID) . ' class="edit btn btn-warning btn-sm m-1" title="Edit Transaksi" data-toggle="tooltip" data-placement="top"><i class="fas fa-edit"></i></a>';
                        $btn = $btn . '<a href=' . route("transaction.show", $encryptID) . ' class="btn btn-info btn-sm m-1" title="Lihat Transaksi" data-toggle="tooltip" data-placement="top"><i class="fas fa-eye"></i></a>';
                        $btn = $btn . '<form class="d-inline m-1" title="Cancel Booking" data-toggle="tooltip" data-placement="top" action=' . route("transaction.cancel", $transaction->id) . ' method="POST">
                        <input type="hidden" name="_token" value=' . csrf_token() . '>
                        <input type="hidden" name="status" value="CANCELED">
                        <button class="btn btn-outline-danger btn-sm" type="submit"><i class="far fa-times-circle"></i></button>
                        </form>';
                    }
                    return $btn;
                })

                ->rawColumns(['action', 'modal'])
                ->make(true);
        }
        return view('transaction.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cars = Car::all();
        $users = User::all();
        return view('transaction.create', compact('cars', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Dibawah ini script otomatis merubah status mobil 0 (unavailable) ketika booking
        // $data = $request->validate([
        //     'user_id' => 'required',
        //     'car_id' => 'required',
        //     'date_start' => 'required',
        //     'date_end' => 'required',
        //     'note' => 'required',
        // ]);
        // $data['date_due'] = $request->date_end;
        // $data['status'] = 'PENDING';
        // $car = Car::find($request->car_id);
        // $date_start = new DateTime($request->date_start);
        // $date_end = new DateTime($request->date_end);
        // $duration = $date_start->diff($date_end);
        // $data['total'] = $car->price * ($duration->days + 1);
        // Transaction::create($data);

        // $car->status = '0';
        // $car->save();

        // return redirect()->route('transaction.index')->with('message', 'Booking mobil berhasil dilakukan!');

        //Dibawah ini script booking status mobil tetap 1 (available) dan akan 0 (unavailable) ketika telah approve, script ini bisa digunakan untuk manajemen booking
        $data = $request->validate([
            'user_id' => 'required',
            'car_id' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'note' => 'required',
        ]);
        $data['date_due'] = $request->date_end;
        $data['status'] = 'PENDING';
        $car = Car::find($request->car_id);
        $date_start = new DateTime($request->date_start);
        $date_end = new DateTime($request->date_end);
        $duration = $date_start->diff($date_end);
        $data['total'] = $car->price * ($duration->days + 1);
        Transaction::create($data);

        return redirect()->route('transaction.index')->with('message', 'Booking mobil berhasil dilakukan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $transaction = Transaction::with('user', 'car')->find($transaction->id);
        $decryptID = Crypt::decrypt($id);
        $transaction = Transaction::with('user', 'car')->find($decryptID);
        return view('transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $decryptID = Crypt::decrypt($id);
        $transaction = Transaction::with('user', 'car')->find($decryptID);
        // $transaction = Transaction::find($id);
        $users = User::all();
        $cars = Car::all();
        return view('transaction.edit', compact('users', 'cars', 'transaction'));
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
        $data = $request->validate([
            'user_id' => 'required',
            'car_id' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
            'note' => 'required',
        ]);
        $car = Car::find($request->car_id);
        $date_start = new DateTime($request->date_start);
        $date_end = new DateTime($request->date_end);
        $duration = $date_start->diff($date_end);
        $data['total'] = $car->price * ($duration->days + 1);
        // $data['total'] = $car->price * $duration->days;
        $transaction->update($data);

        return redirect()->route('transaction.index')->with('message', 'Data booking berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        Transaction::destroy($transaction->id);
        return redirect()->route('transaction.index');
    }

    public function approve(Request $request, Transaction $transaction)
    {
        $transaction->update([
            'status' => $request->status
        ]);

        $transaction = Transaction::with('car')->find($transaction->id);
        $transaction->car->status = '0';
        $transaction->car->save();

        return redirect()->route('transaction.index')->with('message', 'Approval Booking berhasil dilakukan!');
    }

    public function cancel(Request $request, Transaction $transaction)
    {
        $transaction->update([
            'status' => $request->status
        ]);

        $transaction = Transaction::with('car')->find($transaction->id);
        $transaction->car->status = '1';
        $transaction->car->save();
        return redirect()->route('transaction.index')->with('message', 'Pembatalan Booking berhasil dilakukan!');
    }

    public function record(Request $request)
    {
        $transaction = Transaction::all();
        if ($request->ajax()) {
            // $data = Transaction::latest()->get();
            $data = Transaction::where('status', '=', 'DONE')
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
                    if (auth()->user()->name == 'nawan') {
                        $btn = '<form class="d-inline m-1" action=' . route("transaction.destroy", $transaction->id) . ' method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value=' . csrf_token() . '>
                        <button class="btn btn-danger btn-sm btn-flat" type="submit" title="Hapus Transaksi" data-toggle="tooltip" data-placement="top" onclick="deleteConfirm(event)"><i class="fas fa-trash"></i></button>
                        </form>';
                        $btn = $btn . '<a href=' . route("transaction.show", $encryptID) . ' class="btn btn-info btn-sm m-1" title="Lihat Transaksi" data-toggle="tooltip" data-placement="top"><i class="fas fa-eye"></i></a>';
                    } else {
                        $btn = '<a href=' . route("transaction.show", $encryptID) . ' class="btn btn-info btn-sm m-1" title="Lihat Transaksi" data-toggle="tooltip" data-placement="top"><i class="fas fa-eye"></i></a>';
                    }
                    return $btn;
                })

                ->rawColumns(['action', 'modal'])
                ->make(true);
        }
        return view('transaction.record', compact('transaction'));
    }
}
