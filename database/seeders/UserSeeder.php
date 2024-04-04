<?php

namespace Database\Seeders;

// use app\Models\User;
// use app\Models\UserDetail;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name'  =>  'Admin Sistem',
            'nik' => '2043401203200002',
            'no_kontak' => '081647623232',
            'alamat' => 'Jl Parangtritis KM 10',
            'email' =>  'admin2@warehousepro.com',
            'password'  =>  Hash::make('123456789'),
            'is_admin'  =>  1,
        ]);
    }
}
