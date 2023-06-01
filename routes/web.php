<?php

use App\Http\Controllers\ChartController;
use Illuminate\Support\Facades\Route;



Route::get('/',[ChartController::class,'index']);

Route::post('/',[ChartController::class,'store'])->name('chart@store');