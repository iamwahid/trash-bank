<?php

// use App\Http\Controllers\Backend\BimbinganController;

use App\Http\Controllers\Backend\BarangController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\JualanController;
use App\Http\Controllers\Backend\KasirController;
use App\Http\Controllers\Backend\SiswaController;
use App\Http\Controllers\Backend\TransaksiController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);


Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'kasir'], function() {
  Route::get('/', [KasirController::class, 'index'])->name('kasir.index');
  // Route::get('/create', [KasirController::class, 'create'])->name('kasir.create');
  // Route::post('/', [KasirController::class, 'store'])->name('kasir.store');

  Route::group(['prefix' => '/{siswa}'], function(){
    // Route::get('/', [KasirController::class, 'show'])->name('kasir.show');
    Route::get('/barang', [KasirController::class, 'tukar_barang'])->name('kasir.barang');
    Route::post('/barang', [KasirController::class, 'tukar_barang'])->name('kasir.barang.post');
    Route::get('/point', [KasirController::class, 'tukar_point'])->name('kasir.point');
    Route::post('/point', [KasirController::class, 'tukar_point'])->name('kasir.point.post');
    Route::get('/konfirmasi', [KasirController::class, 'konfirmasi'])->name('kasir.konfirmasi');
    Route::post('/konfirmasi', [KasirController::class, 'konfirmasi'])->name('kasir.konfirmasi.post');
  });
});

Route::group(['prefix' => 'siswa'], function() {
  Route::get('/', [SiswaController::class, 'index'])->name('siswa.index');
  Route::get('/create', [SiswaController::class, 'create'])->name('siswa.create');
  Route::post('/', [SiswaController::class, 'store'])->name('siswa.store');

  Route::group(['prefix' => '/{siswa}'], function(){
    Route::get('/', [SiswaController::class, 'show'])->name('siswa.show');
    Route::get('/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::post('/', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/', [SiswaController::class, 'destroy'])->name('siswa.delete');
  });
});

Route::group(['prefix' => 'barang'], function() {
  Route::get('/', [BarangController::class, 'index'])->name('barang.index');
  Route::get('/create', [BarangController::class, 'create'])->name('barang.create');
  Route::post('/', [BarangController::class, 'store'])->name('barang.store');

  Route::group(['prefix' => '/{barang}'], function(){
    Route::get('/', [BarangController::class, 'show'])->name('barang.show');
    Route::get('/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::post('/', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/', [BarangController::class, 'destroy'])->name('barang.delete');
  });
});

Route::group(['prefix' => 'jualan'], function() {
  Route::get('/', [JualanController::class, 'index'])->name('jualan.index');
  Route::get('/create', [JualanController::class, 'create'])->name('jualan.create');
  Route::post('/', [JualanController::class, 'store'])->name('jualan.store');

  Route::group(['prefix' => '/{barang}'], function(){
    Route::get('/', [JualanController::class, 'show'])->name('jualan.show');
    Route::get('/edit', [JualanController::class, 'edit'])->name('jualan.edit');
    Route::post('/', [JualanController::class, 'update'])->name('jualan.update');
    Route::delete('/', [JualanController::class, 'destroy'])->name('jualan.delete');
  });
});

Route::group(['prefix' => 'transaksi'], function() {
  Route::get('/', [TransaksiController::class, 'index'])->name('transaksi.index');
});
