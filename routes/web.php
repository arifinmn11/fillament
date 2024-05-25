<?php

use App\Http\Controllers\CabangController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/update-cabang', [CabangController::class, 'updateCabang'])->name('update-cabang');
