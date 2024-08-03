<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserWebController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/', [ProductController::class, 'getRecommendedProducts'])->name('home');

Route::get('/shop_layout', function () {
    return view('shop_layout');
});

// --------------------- Sell AddItem Shop Auction - --------------------
Route::get('/shop', [ProductController::class, 'shop'])->name('products.shop');

Route::get('/filter-products', [ProductController::class, 'filterProducts'])->name('product.filter');
Route::get('/auction/filter', [ProductController::class, 'filterAuctions'])->name('auction.filter');


Route::get('/auction', [ProductController::class, 'auction'])->name('products.auction');

Route::get('/add_item', [ProfileController::class, 'add_item'])->name('profile.add_item');

Route::post('/add_item', [ProductController::class, 'store'])->name('products.store');

Route::get('/sell', [ProductController::class, 'sell'])->name('profile.sell');

Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');

Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');

Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

Route::put('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');


// ------------------- Auth Login Register --------------------------------
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::post('/register', [UserWebController::class, 'store'])->name('auth.register');

Route::post('/login', [UserWebController::class, 'login'])->name('auth.login');


Route::post('/logout', [UserWebController::class, 'logout'])->name('logout');

Route::post('/check-existing-data', [UserWebController::class, 'checkExistingData'])->name('check.existing.data');



// ---------------------------- Profile --------------------------------
Route::post('/profile/update', [UserWebController::class, 'update'])->name('profile.update');
Route::get('/profile', [UserWebController::class, 'edit'])->name('profile.edit');
Route::post('/profile/check-existing-data', [UserWebController::class, 'checkExistingData'])->name('profile.checkExistingData');
Route::post('/check-old-password', [UserWebController::class, 'checkOldPassword'])->name('profile.check_old_password');
Route::post('/update-password', [UserWebController::class, 'updatePassword'])->name('profile.update_password');


// --------------------------------- Layout Profiles --------------------------------
Route::post('/profile/update-image', [UserWebController::class, 'updateProfileImg'])->name('profile.updateProfileImg');


Route::get('/address', [ProfileController::class, 'editAddress'])->name('profile.address');
Route::post('/address/update', [ProfileController::class, 'updateAddress'])->name('profile.address.update');




// ------------------------------- Show Products --------------------------------
Route::get('/product/{id}', [ProductController::class, 'showshop'])->name('product.showshop');
Route::get('/products/auction/{id}', [ProductController::class, 'showauction'])->name('auction.show');




// web.php
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/wishlist/add', [CartController::class, 'addToWishlist'])->name('wishlist.add');
Route::post('/wishlist/remove', [CartController::class, 'removeFromWishlist'])->name('wishlist.remove');
Route::get('/wishlist', [CartController::class, 'showWishlist'])->name('wishlist.show');


Route::get('/cart', [ProfileController::class, 'showCart'])->name('cart.show');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::post('/cart/updateQuantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');


                
Route::get('/rate_star', function () {
    return view('rate_star');
})->name('rate_star');


Route::get('/rate_star/{id}/{product_id}/{source}', [ProfileController::class, 'showRateStar'])->name('rate_star');

Route::post('/submit_rating/{id}', [ProfileController::class, 'submitRating'])->name('submit_rating');



