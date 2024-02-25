<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Auth;


Route::group(['prefix' => 'admin','as' => 'admin.','middleware' => ['auth','admin']], function(){
    Route::get('/',[DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', UserController::class);
});
Auth::routes();


require __DIR__.'/front.php';
