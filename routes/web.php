<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\ProductController;

Route::group(['prefix' => 'admin','as' => 'admin.','middleware' => ['auth','admin']], function(){
    Route::get('/',[DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users/restore', [UserController::class,'deletes'])->name('users.restore');
    Route::post('/users/{id}/restore', [UserController::class,'restore'])->name('users.restore.restore');
    Route::resource('/users', UserController::class);

    Route::get('/tags/restore', [TagController::class,'deletes'])->name('tags.restore');
    Route::post('/tags/{id}/restore', [TagController::class,'restore'])->name('tags.restore.restore');
    Route::resource('/tags', TagController::class);
    
    Route::get('/categories/restore', [CategoryController::class,'deletes'])->name('categories.restore');
    Route::post('/categories/{id}/restore', [CategoryController::class,'restore'])->name('categories.restore.restore');
    Route::resource('/categories', CategoryController::class);

    Route::get('/posts/restore', [PostController::class,'deletes'])->name('posts.restore');
    Route::post('/posts/{id}/restore', [PostController::class,'restore'])->name('posts.restore.restore');
    Route::resource('/posts', PostController::class);
    
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products', [ProductController::class, 'admin_index'])->name('products.index');
    Route::get('/product/{product}', [ProductController::class, 'admin_show'])->name('products.show');
    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class , 'destroy'])->name('products.destroy');

});

Route::get('/auth/{provider}/redirect',[SocialController::class,'redirect']);
Route::get('/auth/{provider}/callback',[SocialController::class,'callback']);

Auth::routes();


require __DIR__.'/front.php';
