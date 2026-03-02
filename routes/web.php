<?php

use App\Http\Controllers\DataPegawai;
use Illuminate\Support\Facades\Route;

Route::get('/', [DataPegawai::class, 'index']);
Route::post('/tambahPegawai', [DataPegawai::class, 'store'])->name('tambahPegawai');
Route::get('/dataPegawai',[DataPegawai::class,'showData'])->name('showData');
Route::get('/dataPegawai/{id}',[DataPegawai::class,'detail'])->name('detailPegawai');
Route::delete('/hapusPegawai/{id}',[DataPegawai::class,'destroy'])->name('hapusPegawai');
Route::post('/editPegawai/{id}',[DataPegawai::class,'edit'])->name('editPegawai');


