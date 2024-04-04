<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AvailableCarsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CetakController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UsedCarsController;
use App\Models\Payment;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard.index');
// })->middleware(['auth'])->name('dashboard');

Route::get('/dashboard', DashboardController::class)->middleware(['auth'])->name('dashboard');

// profile
Route::get('/profile', [ProfileController::class, 'profile'])->middleware(['auth'])->name('profile');
Route::post('/profile', [ProfileController::class, 'change_profile'])->middleware(['auth'])->name('profile.change');
// Route::get('/profile', [ProfileController::class, 'edit'])->middleware(['auth'])->name('profile.edit');
// Route::post('/profile', [ProfileController::class, 'update'])->middleware(['auth'])->name('profile.update');

// change password
Route::get('/change-password', [ProfileController::class, 'password'])->middleware(['auth'])->name('change-password');
Route::post('/change-password', [ProfileController::class, 'change_password'])->middleware(['auth'])->name('change-password.change');


Route::middleware(['auth'])->resource('/car', CarController::class);
Route::middleware(['auth'])->resource('/user', UserController::class);
Route::middleware(['auth'])->resource('/admin', AdminController::class);
Route::middleware(['auth'])->resource('/transaction', TransactionController::class);
Route::middleware(['auth'])->resource('/payment', PaymentsController::class);
Route::middleware(['auth'])->resource('/availablecar', AvailableCarsController::class);
Route::middleware(['auth'])->resource('/usedcar', UsedCarsController::class);
Route::post('transaction/{transaction:id}/approve', [TransactionController::class, 'approve'])->name('transaction.approve');
Route::post('transaction/{transaction:id}/cancel', [TransactionController::class, 'cancel'])->name('transaction.cancel');
Route::post('usedcar/{transaction:id}/status', [UsedCarsController::class, 'status'])->name('usedcar.status');
Route::get('booking/{id}', [AvailableCarsController::class, 'booking'])->name('availablecar.booking');
Route::get('pay/{id}', [PaymentsController::class, 'pay'])->name('payment.pay');
Route::get('/paymenthistory', [PaymentsController::class, 'history'])->middleware(['auth'])->name('payment.history');
Route::get('/suratjalan', [CetakController::class, 'surat_jalan'])->middleware(['auth'])->name('suratjalan');
Route::get('/buktibayar', [CetakController::class, 'bukti_bayar'])->middleware(['auth'])->name('buktibayar');
Route::get('/laporan-mobil', [ReportController::class, 'report_car'])->middleware(['auth'])->name('laporan-mobil');
Route::get('/laporan-pelanggan', [ReportController::class, 'report_pelanggan'])->middleware(['auth'])->name('laporan-pelanggan');

// Route::get('/laporan-pelanggan', [ReportController::class, 'report_user'])->middleware(['auth'])->name('laporan-pelanggan');
Route::get('/laporan-pembayaran', [ReportController::class, 'report_pembayaran'])->middleware(['auth'])->name('laporan-pembayaran');
Route::get('/receipt/{id}', [CetakController::class, 'receipt'])->middleware(['auth'])->name('receipt');
Route::get('/cetakreceipt/{id}', [CetakController::class, 'cetakreceipt'])->middleware(['auth'])->name('cetakreceipt');
Route::get('/record', [TransactionController::class, 'record'])->middleware(['auth'])->name('transaction.record');
Route::delete('car/{id}', [CarController::class, 'destroy'])->name('car.destroy');
Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
Route::delete('admin/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
// Route::delete('transaction/{id}', [TransactionController::class, 'destroy'])->name('transaction.destroy');




// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//     Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
//     Route::post('/profile', [ProfileController::class, 'change_profile'])->name('profile.change');
// });

require __DIR__ . '/auth.php';

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
