<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InputController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\UserController;

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
})->middleware('auth');

// Auth
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Profil
Route::get('/profil', [UserController::class, 'index'])->name('profil');
Route::get('/profil/edit', [UserController::class, 'edit'])->name('profil.edit');
Route::put('/profil/edit', [UserController::class, 'update'])->name('profil.update');

// User
Route::get('/users', [UserController::class, 'list'])->name('users.list'); // not yet
Route::get('/users/{user:username}', [UserController::class, 'userdetail'])->name('users.list.detail');
Route::get('/users/{user:username}/edit', [UserController::class, 'useredit'])->name('users.edit');
Route::put('/users/{user:username}/edit', [UserController::class, 'update'])->name('users.update');
Route::get('/register', [UserController::class, 'reg'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register.post');
Route::delete('/users/{user:id}/delete', [UserController::class, 'delete'])->name('users.delete'); // not yet

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
Route::get('/rekap', [OutputController::class, 'rekap'])->name('rekap');

// Panduan & URK
Route::put('/unggah/panduan/{panduan:id}', [PanduanController::class, 'update_panduan'])->name('panduan.update');
Route::put('/unggah/urk/{urk:id}', [PanduanController::class, 'update_urk'])->name('urk.update');
