<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;


// Auth
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Profil
Route::get('/profil', [UserController::class, 'index'])->name('profil');
Route::get('/profil/edit', [UserController::class, 'edit'])->name('profil.edit');
Route::put('/profil/edit/{user:username}', [UserController::class, 'update'])->name('profil.update');
Route::put('/profil/{user}/edit/password', [UserController::class, 'update_password'])->name('profil.update.password');


// User
Route::get('/users', [UserController::class, 'list'])->name('users.list');
Route::get('/users/{user:username}', [UserController::class, 'userdetail'])->name('users.list.detail');
Route::get('/users/{user:username}/edit', [UserController::class, 'useredit'])->name('users.edit');
Route::put('/users/{user:username}/update', [UserController::class, 'update'])->name('users.update');
Route::get('/user/tambah',  [UserController::class, 'create'])->name('users.create');
Route::post('/user/tambah/post', [UserController::class, 'daftar'])->name('users.post');
Route::delete('/users/{user:id}/delete', [UserController::class, 'delete'])->name('users.delete');

// Input
// Laporan
Route::get('/laporan', [InputController::class, 'index'])->name('laporan');
Route::get('/laporan/{user:username}', [InputController::class, 'list'])->name('laporan.list');
Route::get('/tambah/laporan/', [InputController::class, 'create'])->name('laporan.create');
Route::post('/tambah/laporan', [InputController::class, 'store'])->name('laporan.store');
Route::get('/laporan/{oneinput}/detail', [InputController::class, 'show'])->name('laporan.show');
Route::get('/laporan/{oneinput}/sunting', [InputController::class, 'edit'])->name('laporan.edit');
Route::put('/laporan/{oneinput}/sunting', [InputController::class, 'update'])->name('laporan.update');
Route::delete('/laporan/{oneinput}/hapus', [InputController::class, 'destroy'])->name('laporan.destroy');

// Dokumen
Route::get('/dokumen', [InputController::class, 'index_dokumen'])->name('dokumen');
Route::delete('/dokumen/destroy/{twoinput:id}', [InputController::class, 'destroy_dokumen'])->name('destroy.dokumen');
Route::post('/dokumen/store', [InputController::class, 'store_dokumen'])->name('store.dokumen');
Route::post('/dokumen/edit/{twoinput:id}', [InputController::class, 'edit_dokumen'])->name('edit.dokumen');

// Output
Route::get('/', [OutputController::class, 'index'])->name('dashboard');
Route::get('/list', [OutputController::class, 'list'])->name('list');
Route::get('/rekap/{user:username}', [OutputController::class, 'rekap'])->name('rekap');

// Output Excel

// Rekap
Route::get('/rekap/excel/all/table/', [ExportController::class, 'rekapAllExport'])->name('rekap.excel.table.all'); // Monitoring
Route::get('/rekap/excel/table/{user:id}', [ExportController::class, 'rekapExport'])->name('rekap.excel.table'); // Satker

// Laporan
Route::get('/output/excel/all/table', [ExportController::class, 'exportWithAllView'])->name('output.excel.table.all'); // Monitoring
Route::get('/output/excel/table/{user:id}', [ExportController::class, 'exportWithView'])->name('output.excel.table'); // Satker

// Panduan & URK
Route::put('/unggah/panduan/{panduan:id}', [PanduanController::class, 'update_panduan'])->name('panduan.update');
Route::put('/unggah/urk/{urk:id}', [PanduanController::class, 'update_urk'])->name('urk.update');
