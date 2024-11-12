<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserWebController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Http\Controllers\BroadcastingController; // นำเข้า controller
use App\Models\UserWeb; // เพิ่มบรรทัดนี้ที่ด้านบนของไฟล์
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuctionController;

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
})->name('login');

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


// routes/web.php
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return 'Database connection is successful!';
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});


Route::post('/verify-otp', [UserWebController::class, 'verifyOtp'])->name('verify.otp');

// --------------------- Social Authentication ---------------------
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
Route::get('auth/facebook', [FacebookController::class, 'redirect'])->name('auth.facebook.redirect');
Route::get('auth/facebook/callback', [FacebookController::class, 'callback'])->name('auth.facebook.callback');

Route::post('/password/email', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? response()->json(['success' => true])
        : response()->json(['success' => false], 400);
})->name('auth.password.email'); 

Route::get('password/reset/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');


// --------------------- Broadcasting Routes ---------------------
    // --------------------- Chat Routes ---------------------
    Route::get('/chat', [ChatController::class, 'fetchUsers'])->name('chat')->middleware('auth');
    Route::get('/chat2', [ChatController::class, 'fetchUsers'])->name('chat2')->middleware('auth');
    Route::get('/chat-history/{username}', [ChatController::class, 'getChatHistory']);
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');
    Route::post('/test-send-message', [ChatController::class, 'testSendMessage'])->name('test.send.message');

Route::middleware(['auth'])->group(function () {
    Route::post('/broadcasting/auth', [BroadcastingController::class, 'authenticate']);
    Route::post('/store-message', [ChatController::class, 'store'])->name('store.message');
    Route::post('/send-message2', function (Request $request) {
        $username = auth()->user()->username; // ชื่อผู้ส่ง
        $senderId = auth()->user()->id; // ID ของผู้ส่ง
        $recipientUsername = $request->input('recipient'); // ชื่อผู้รับจาก request
        $message = $request->input('message'); // ข้อความที่ส่ง
        $time = now(); // เวลาปัจจุบัน

        // ค้นหา user ตาม username
        $recipientUser = UserWeb::where('username', $recipientUsername)->first(); // ค้นหาผู้ใช้ตาม username

        // กำหนด recipientId และ check ว่าพบผู้ใช้หรือไม่
        if ($recipientUser) {
            $recipientId = $recipientUser->id; // ถ้าพบให้เก็บ ID
        } else {
            return response()->json(['success' => false, 'message' => 'Recipient not found.'], 404);
        }

        // ส่ง event
        event(new MessageSent($username, $senderId, $recipientId, $recipientUsername, $message, $time));

        return ["success" => true];
    });
});

Route::post('/upload-image', [ChatController::class, 'uploadImage']);

Route::post('/bid', [AuctionController::class, 'bid']);

Route::get('/get-current-price/{id}', [AuctionController::class, 'getCurrentPrice']);

Route::get('/auction/current-price/{id}', [AuctionController::class, 'getCurrentPrice']);
