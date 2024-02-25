<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Front'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('main');
    // Route::get('/', [HomeController::class,'index'])->name('main');

});
