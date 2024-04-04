<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Transaction;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $cars = Car::latest()->paginate(10);
        // return view('cars.index')->with('cars', $cars);

        $search = $request->search;
        $cars = Car::where('name', 'like', '%' . $search . '%')
            ->orWhere('plat', 'like', '%' . $search . '%')
            ->orWhere('price', 'like', '%' . $search . '%')
            ->latest()
            ->paginate(10);
        return view('cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cars.create');
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
            'name'  =>  'required',
            'plat'  =>  'required',
            'description'  =>  'required',
            'status'  =>  'required',
        ]);

        $data['price'] = Str::replace('.', '', $request->price);
        if ($request->file('image')) {
            $data['image'] = $request->file('image')->store('cars');
        }
        Car::create($data);
        return redirect()->route('car.index')->with('message', 'Data Mobil Berhasil Ditambahkan!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $decryptID = Crypt::decrypt($id);
        $car = Car::find($decryptID);
        // $user = User::with('userdetail')
        //     ->find($user->id)
        //     ->find($decryptID);
        $transactions = Transaction::where('car_id', '=', $decryptID)
            ->latest()
            ->paginate(10);
        // if ($request->ajax()) {
        //     $data = Transaction::where('car_id', '=', $decryptID)
        //         ->latest()->get();

        //     return DataTables::of($data)
        //         ->addIndexColumn()
        //         ->editColumn('car_id', function (Transaction $transaction) {
        //             $transaction = Transaction::with('car');
        //             return $transaction->car->name;
        //         })
        //         ->editColumn('user_id', function (Transaction $transaction) {
        //             $transaction = Transaction::with('user');
        //             return $transaction->user->name;
        //         })
        //         ->editColumn('date_start', function (Transaction $transaction) {
        //             return Carbon::parse($transaction->date_start)->format('d F Y');
        //         })
        //         ->editColumn('date_end', function (Transaction $transaction) {
        //             return Carbon::parse($transaction->date_end)->format('d F Y');
        //         })
        //         ->editColumn('total', function (Transaction $transaction) {
        //             return number_format($transaction->total, 0);
        //         })
        //         ->editColumn('note', function (Transaction $transaction) {
        //             return $transaction->note;
        //         })
        //         ->make(true);
        // }

        return view('cars.show', compact('car', 'transactions'));
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
        return view('cars.edit', compact('car'));
        // return view('cars.edit', ['car' => $car]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $data = $request->validate([
            'name' => 'required',
            'plat' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $data['price'] = Str::replace('.', '', $request->price);
        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $data['image'] = $request->file('image')->store('cars');
        }
        $car->update($data);
        return redirect()->route('car.index')->with('message', 'Data Mobil Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        if ($car->image) {
            Storage::delete($car->image);
        }
        Car::destroy($car->id);
        return redirect()->route('car.index');
    }

    public function history(Request $request)
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
                    return Carbon::parse($transaction->date_start)->format('d F Y');
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
    }
}
