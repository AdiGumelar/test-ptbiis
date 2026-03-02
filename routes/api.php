<?php

use App\Http\Controllers\DataPegawai;
use Illuminate\Support\Facades\Route;

Route::prefix('employees')->group(function () {
    Route::get('/', [DataPegawai::class, 'showData']);
    Route::get('/{id}', [DataPegawai::class, 'detail']);
    Route::post('/', [DataPegawai::class, 'store']);
    Route::put('/{id}', [DataPegawai::class, 'edit']);
    Route::delete('/{id}', [DataPegawai::class, 'destroy']);
});


