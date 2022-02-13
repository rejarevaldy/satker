<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InputController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

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
    return view('welcome');
});

// Auth
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Input
    // Laporan
    Route::get('/laporan', [InputController::class, 'index'])->name('laporan');
    Route::get('/laporan/tambah', [InputController::class, 'create'])->name('laporan.create');
    Route::post('/laporan/tambah', [InputController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{oneinput}', [InputController::class, 'show'])->name('laporan.show');
    Route::get('/laporan/{oneinput}/sunting', [InputController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{oneinput}/sunting', [InputController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{oneinput}/hapus', [InputController::class, 'destroy'])->name('laporan.destroy');
    // Dokumen
    Route::get('/dokumen', [InputController::class, 'index_dokumen'])->name('dokumen');
    Route::delete('/dokumen/destroy/{twoinput:id}', [InputController::class, 'destroy_dokumen'])->name('destroy.dokumen');
    Route::post('/dokumen/store', [InputController::class, 'store_dokumen'])->name('store.dokumen');
    Route::post('/dokumen/edit/{twoinput:id}', [InputController::class, 'edit_dokumen'])->name('edit.dokumen');

// Output
Route::get('/beranda', [OutputController::class, 'index'])->name('dashboard');

// Panduan & URK
Route::put('/unggah/panduan/{panduan:id}', [PanduanController::class, 'update_panduan'])->name('panduan.update');
Route::put('/unggah/urk/{urk:id}', [PanduanController::class, 'update_urk'])->name('urk.update');
