<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Transaction;
use Illuminate\Support\Facades\Crypt;
use illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $users)
    {
        $search = $request->search;
        $users = User::where('is_admin', '=', 1)
            ->where('name', 'like', '%' . $search . '%')
            ->latest()
            ->paginate(10);

        return view('admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.create');
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
            'name' => 'required',
            'is_admin' => 'required',
            // verifikasi apakah email sudah ada atau belum
            'email' => 'required|email:rfc,dns|unique:App\Models\User,email',
            'nik' => 'required',
            'no_kontak' => 'required',
            'image' => 'required',
            'alamat' => 'required',
            'password' => 'required',
        ]);

        $data['password'] = Hash::make($request->password);

        if ($request->file('image')) {
            $data['image'] = $request->file('image')->store('users');
        }

        User::create($data);

        return redirect()->route('admin.index')->with('message', 'Data Admin Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $decryptID = Crypt::decrypt($id);
        $user = User::find($decryptID);
        $name = $user->name;

        $payments = Payment::where('created_by', '=', $name)
            ->latest()
            ->paginate(10);

        // $transactions = Transaction::where('user_id', '=', $decryptID)
        //     ->latest()
        //     ->paginate(10);
        return view('admin.show', compact('user', 'payments'));
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
        $user = User::find($decryptID);
        return view('admin.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
