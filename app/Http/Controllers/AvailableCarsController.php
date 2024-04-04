<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use App\Models\Transaction;
use Yajra\DataTables\DataTables;
use DateTime;

class AvailableCarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Transaction $transaction)
    {
        if ($request->ajax()) {
            $data = Car::where('status', '=', '1')
                ->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('car_id', function (Car $car) {
                    return $car->name;
                })
                ->editColumn('image', function (Car $car) {
                    return $car->image;
                })
                ->editColumn('plat', function (Car $car) {
                    return $car->plat;
                })
                ->editColumn('status', function (Car $car) {
                    return $car->status;
                })
                ->editColumn('harga', function (Car $car) {
                    return number_format($car->price, 0, ',', '.');
                })
                ->addColumn('action', function (Car $car) {
                    $encryptID = Crypt::encrypt($car->id);
                    $btn = '<a href=' . route("availablecar.booking", $encryptID) . ' class="btn btn-primary btn-sm" title="Booking" data-toggle="tooltip" data-placement="top"><i class="fa fa-plus-square"></i> Booking</a>';
                    return $btn;
                })
                ->make(true);
        }

        return view('availablecars.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function booking($id, Car $car)
    {
        $decryptID = Crypt::decrypt($id);

        $car = Car::find($decryptID);
        $users = User::all();
        $transactions = Transaction::all();

        $price = number_format($car->total, 0);


        return view('availablecars.booking', compact('car', 'users', 'transactions', 'price'));
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
        $decryptID = Crypt::decrypt($id);

        $car = Car::find($decryptID);
        $users = User::all();
        $transactions = Transaction::all();
        return view('availablecars.edit', compact('car', 'users', 'transactions'));
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
}
