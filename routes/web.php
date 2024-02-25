<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use Illuminate\Support\Facades\Auth;


Route::group(['prefix' => 'admin','as' => 'admin.','middleware' => ['auth','admin']], function(){
    Route::get('/',[DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users/restore', [UserController::class,'deletes'])->name('users.restore');
    
    Route::post('/users/{id}/restore', [UserController::class,'restore'])->name('users.restore.restore');

    Route::resource('/users', UserController::class);

    Route::resource('/tags', TagController::class);
    Route::resource('/categories', CategoryController::class);
    Route::resource('/posts', PostController::class);
});
Auth::routes();


require __DIR__.'/front.php';
