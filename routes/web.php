<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\RegisterController;
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
Route::get('/users', [UserController::class, 'list'])->name('users.list'); 
Route::get('/users/{user:username}', [UserController::class, 'userdetail'])->name('users.list.detail'); 
Route::get('/users/{user:username}/edit', [UserController::class, 'useredit'])->name('users.edit'); 
Route::put('/users/{user:username}/edit', [UserController::class, 'update'])->name('users.update'); 
Route::get('/users/create', [RegisterController::class, 'reg'])->name('users.create'); 
Route::post('/users/create', [RegisterController::class, 'store'])->name('users.post'); 
Route::delete('/users/{user:id}/delete', [UserController::class, 'delete'])->name('users.delete'); 

// Input
Route::get('/laporan', [InputController::class, 'index'])->name('laporan');
Route::get('/laporan/tambah', [InputController::class, 'create'])->name('laporan.create');
Route::post('/laporan/tambah', [InputController::class, 'store'])->name('laporan.store');
Route::get('/laporan/{oneinput}', [InputController::class, 'show'])->name('laporan.show');
Route::get('/laporan/{oneinput}/sunting', [InputController::class, 'edit'])->name('laporan.edit');
Route::put('/laporan/{oneinput}/sunting', [InputController::class, 'update'])->name('laporan.update');
Route::delete('/laporan/{oneinput}/hapus', [InputController::class, 'destroy'])->name('laporan.destroy');

// Output 
Route::get('/beranda', [OutputController::class, 'index'])->name('dashboard');
Route::get('/rekap', [OutputController::class, 'rekap'])->name('rekap');

// Panduan & URK
Route::put('/unggah/panduan/{panduan:id}', [PanduanController::class, 'update_panduan'])->name('panduan.update');
Route::put('/unggah/urk/{urk:id}', [PanduanController::class, 'update_urk'])->name('urk.update');