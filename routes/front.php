<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\Front\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payments\PaymentController;



Route::group(['namespace' => 'Front'], function () {
    
    Route::get('/', [ProductController::class, 'index'])->name('main');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('products.show');
    
    Route::get('/product/download/{product}/{download_tkn}', [ProductController::class,'download'])->middleware(['auth','signed'])->name('product.download');
    Route::get('/product/generate/{user}/{product}', [ProductController::class,'generateDownloadLink'])->middleware(['auth','isUser'])->name('product.generate');

    Route::get('/user/{user}/profile/products',[ProductController::class,'products'])->name('users.products')->middleware('auth');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('post.show');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

    Route::get('/checkout', [PaymentController::class, 'payProcessing'])->name('checkout');
    Route::match('post','/callback', [PaymentController::class, 'callback'])->name('fondy.callback');
});
