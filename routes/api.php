<?php

use App\Http\Controllers\Api\BarangController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\KasirController;
use App\Http\Controllers\Api\WargaController;
use App\Http\Controllers\Backend\Auth\Role\RoleController;
use App\Http\Controllers\Backend\Auth\User\UserController;
use App\Http\Controllers\Backend\BimbinganController;
use App\Http\Controllers\Frontend\Auth\ApiLoginController;

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [ApiLoginController::class, 'login']);
    Route::post('signup', [ApiLoginController::class, 'signup']);
    
    Route::group(['middleware' => 'auth:api' ], function() {
        Route::get('profile', [ApiLoginController::class, 'user']);

        Route::get('logout', [ApiLoginController::class, 'logout']);
        Route::post('refresh', [ApiLoginController::class, 'refresh']);
    });
});

Route::group(['prefix' => 'home', 'middleware' => 'auth:api'], function () {
    Route::get('', [DashboardController::class, 'index']);
    Route::get('transaksi', [DashboardController::class, 'transaksi']);
    Route::post('ambil_point', [DashboardController::class, 'ambil_point']);
    Route::post('update_profile', [DashboardController::class, 'updateProfile']);
    Route::post('update_password', [DashboardController::class, 'updatePassword']);
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', /*'role:admin'*/]], function () {
    Route::group(['prefix' => 'barang'], function () {
        Route::get('', [BarangController::class, 'index']);
        Route::post('', [BarangController::class, 'store']);
        Route::get('{barang}', [BarangController::class, 'show']);
        Route::post('{barang}', [BarangController::class, 'update']);
        Route::delete('{barang}', [BarangController::class, 'destroy']);
    });

    Route::group(['prefix' => 'warga'], function () {
        Route::get('', [WargaController::class, 'index']);
        Route::post('', [WargaController::class, 'store']);
        Route::get('{warga}', [WargaController::class, 'show']);
        Route::post('{warga}', [WargaController::class, 'update']);
        Route::delete('{warga}', [WargaController::class, 'destroy']);
    });

    Route::get('users', [UserController::class, 'indexJson']);
    Route::get('user/{id}', [UserController::class, 'showJson']);
    Route::get('roles', [RoleController::class, 'indexJson']);
});

Route::group(['prefix' => 'kasir', 'middleware' => ['auth:api', /*'role:koordinator'*/]], function () {
    Route::get('', [KasirController::class, 'index']);
    Route::post('scan', [KasirController::class, 'scanBarcode']);
    Route::post('tukar_barang/{warga}', [KasirController::class, 'tukar_barang']);
    Route::post('ambil_point/{warga}', [KasirController::class, 'ambil_point']);
    Route::post('konfirmasi/{warga}', [KasirController::class, 'konfirmasi']);
});

Route::group(['prefix' => 'config'], function () {
    Route::get('rt_list', function(){
        return config('trashbank.rt_list', []);
    });
    Route::get('barang_type', function(){
        return config('trashbank.barang.type', []);
    });
});
