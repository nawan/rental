<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Transaction;
use Illuminate\Support\Facades\Crypt;
use illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $users)
    {
        $search = $request->search;
        $users = User::where('is_admin', '=', 0)
            ->where('name', 'like', '%' . $search . '%')
            ->latest()
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');

        // $users = User::all();
        // $userdetail = UserDetail::all();
        // return view('users.create', compact('users', 'userdetail'));
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
            // verifikasi apakah email sudah ada atau belum
            'email' => 'required|email:rfc,dns|unique:App\Models\User,email',
            'nik' => 'required',
            'no_kontak' => 'required',
            'alamat' => 'required',
            'image' => 'required|image',
        ]);
        $data['password'] = Crypt::encrypt(Str::random(8));
        // $data['password'] = Hash::make('123456789');
        if ($request->file('image')) {
            $data['image'] = $request->file('image')->store('users');
        }

        User::create($data);

        // $id = User::create($data)->id;
        // UserDetail::create([
        //     'user_id' => $id,
        //     'nik' => $request['nik'],
        //     'no_kontak' => $request['no_kontak'],
        //     'alamat' => $request['alamat'],
        // ]);
        return redirect()->route('user.index')->with('message', 'Data Pelanggan Berhasil Ditambahkan');
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

        $transactions = Transaction::where('user_id', '=', $decryptID)
            ->latest()
            ->paginate(10);
        return view('users.show', compact('user', 'transactions'));
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
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  User $user)
    {
        $data = $request->validate([
            'name' => 'required',
            'nik' => 'required',
            'alamat' => 'required',
            'no_kontak' => 'required',
        ]);
        $data['password'] = Hash::make($request->password);
        $user->name = $request->name;
        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $user->image = $request->file('image')->store('users');
        }
        $user->update($data);

        if ($user->is_admin = $request->is_admin) {
            return redirect()->route('admin.index')->with('message', 'Data Admin Berhasil Diupdate !');
        } else {
            return redirect()->route('user.index')->with('message', 'Data Pelanggan Berhasil Diupdate !');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->image) {
            Storage::delete($user->image);
        }
        User::destroy($user->id);
        if ($user->is_admin == 1) {
            return redirect()->route('admin.index');
        } else {
            return redirect()->route('user.index');
        }
    }
}
