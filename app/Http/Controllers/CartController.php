<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartWishList;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\UserWeb;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function addToCart(Request $request)
    {
        try {
            $userId = $request->user_id;
            $productId = $request->product_id;
            $productQty = $request->product_qty;
            $currentDateTime = now()->toDateTimeString(); // วันที่และเวลาปัจจุบัน

            // ค้นหาหรือสร้าง CartWishList สำหรับผู้ใช้
            $cart = CartWishList::firstOrCreate(['id_user' => $userId]);

            // เพิ่มสินค้าลงใน cart
            $cartProducts = $cart->cart_product_ids ?? [];
            $cartQuantities = $cart->cart_product_quantities ?? [];
            $cartDates = $cart->add_cart_date ?? [];

            if (!in_array($productId, $cartProducts)) {
                $cartProducts[] = $productId;
                $cartQuantities[] = $productQty;
                $cartDates[] = $currentDateTime;
            } else {
                $index = array_search($productId, $cartProducts);
                $cartQuantities[$index] = $productQty;
                $cartDates[$index] = $currentDateTime;
            }

            $cart->cart_product_ids = $cartProducts;
            $cart->cart_product_quantities = $cartQuantities;
            $cart->add_cart_date = $cartDates;
            $cart->save();

            return response()->json(['message' => 'Product added to cart successfully']);
        } catch (\Exception $e) {
            Log::error('Error adding to cart: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to add product to cart'], 500);
        }
    }

    public function addToWishlist(Request $request)
    {
        try {
            $userId = $request->user_id;
            $productId = $request->product_id;
            $currentDateTime = now()->toDateTimeString(); // วันที่และเวลาปัจจุบัน

            // ค้นหาหรือสร้าง CartWishList สำหรับผู้ใช้
            $cart = CartWishList::firstOrCreate(['id_user' => $userId]);

            // เพิ่มสินค้าลงใน wishlist
            $wishlistProducts = $cart->wish_list_product_ids ?? [];
            $wishlistDates = $cart->add_wish_list_date ?? [];

            if (!in_array($productId, $wishlistProducts)) {
                $wishlistProducts[] = $productId;
                $wishlistDates[] = $currentDateTime;
            }

            $cart->wish_list_product_ids = $wishlistProducts;
            $cart->add_wish_list_date = $wishlistDates;
            $cart->save();

            return response()->json(['message' => 'Product added to wishlist successfully']);
        } catch (\Exception $e) {
            Log::error('Error adding to wishlist: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to add product to wishlist'], 500);
        }
    }

    public function removeFromWishlist(Request $request)
    {
        $userId = $request->input('user_id');
        $productId = $request->input('product_id');

        // Fetch the cart_wish_list record for the user
        $cartWishList = CartWishList::where('id_user', $userId)->first();

        if ($cartWishList) {
            // Update wish_list_product_ids column
            $wishListProductIds = $cartWishList->wish_list_product_ids ?? [];
            $wishListDates = $cartWishList->add_wish_list_date ?? [];

            if (in_array($productId, $wishListProductIds)) {
                $index = array_search($productId, $wishListProductIds);
                if ($index !== false) {
                    unset($wishListProductIds[$index]);
                    unset($wishListDates[$index]);
                }
            }

            $cartWishList->wish_list_product_ids = array_values($wishListProductIds);
            $cartWishList->add_wish_list_date = array_values($wishListDates);
            $cartWishList->save();

            return response()->json(['message' => 'Product removed from wishlist successfully.']);
        }

        return response()->json(['message' => 'Product not found in wishlist.'], 404);
    }

    public function removeFromCart(Request $request)
    {
        $userId = $request->input('user_id');
        $productId = $request->input('product_id');

        // Fetch the cart_wish_list record for the user
        $cartWishList = CartWishList::where('id_user', $userId)->first();

        if ($cartWishList) {
            // Update cart_product_ids, cart_product_quantities, and add_cart_date columns
            $cartProductIds = $cartWishList->cart_product_ids ?? [];
            $cartProductQuantities = $cartWishList->cart_product_quantities ?? [];
            $addCartDates = $cartWishList->add_cart_date ?? [];

            if (in_array($productId, $cartProductIds)) {
                // Remove product id and corresponding date and quantity
                $key = array_search($productId, $cartProductIds);
                unset($cartProductIds[$key]);
                unset($cartProductQuantities[$key]);
                unset($addCartDates[$key]);

                // Update the database record
                $cartWishList->cart_product_ids = array_values($cartProductIds);
                $cartWishList->cart_product_quantities = array_values($cartProductQuantities);
                $cartWishList->add_cart_date = array_values($addCartDates);
                $cartWishList->save();

                return response()->json(['message' => 'Product removed from cart successfully.']);
            }
        }

        return response()->json(['message' => 'Product not found in cart.'], 404);
    }


    public function update(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            $productId = $request->input('product_id');
            $productQty = $request->input('product_qty');
            $currentDateTime = now()->toDateTimeString();

            // ค้นหาหรือสร้าง CartWishList สำหรับผู้ใช้
            $cart = CartWishList::firstOrCreate(['id_user' => $userId]);

            // อัพเดทข้อมูลสินค้าในตะกร้า
            $cartProducts = $cart->cart_product_ids ?? [];
            $cartQuantities = $cart->cart_product_quantities ?? [];
            $cartDates = $cart->add_cart_date ?? [];

            if (!in_array($productId, $cartProducts)) {
                $cartProducts[] = $productId;
                $cartQuantities[] = $productQty;
                $cartDates[] = $currentDateTime;
            } else {
                $index = array_search($productId, $cartProducts);
                $cartQuantities[$index] = $productQty;
                $cartDates[$index] = $currentDateTime;
            }

            $cart->cart_product_ids = $cartProducts;
            $cart->cart_product_quantities = $cartQuantities;
            $cart->add_cart_date = $cartDates;
            $cart->save();

            return response()->json(['message' => 'Cart updated successfully']);
        } catch (\Exception $e) {
            Log::error('Error updating cart: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to update cart'], 500);
        }
    }

    // public function showWishlist()
    // {
    //     $userId = auth()->id(); // รับ user_id จากการเข้าสู่ระบบ
    //     $cartWishList = CartWishList::where('id_user', $userId)->first();
    //     $user = Auth::user();


    //     $ratings = json_decode($user->rating, true);

    //     // ตรวจสอบว่าค่าของ $ratings เป็น array และไม่เป็น null
    //     if (is_array($ratings)) {
    //         $averageRating = floor(array_sum($ratings) / count($ratings));
    //     } else {
    //         $averageRating = 0;
    //     }

    //     if ($cartWishList) {
    //         // ตรวจสอบประเภทของ wish_list_product_ids และ add_wish_list_date
    //         $wishlistProductIds = is_string($cartWishList->wish_list_product_ids) ? json_decode($cartWishList->wish_list_product_ids, true) : $cartWishList->wish_list_product_ids;
    //         $wishlistDates = is_string($cartWishList->add_wish_list_date) ? json_decode($cartWishList->add_wish_list_date, true) : $cartWishList->add_wish_list_date;

    //         // รวม id ของสินค้า วันที่ เพื่อการเรียงลำดับ
    //         $productsWithDates = array_map(function ($id, $date) {
    //             return ['id' => $id, 'date' => $date];
    //         }, $wishlistProductIds, $wishlistDates);

    //         // เรียงลำดับตาม add_wish_list_date จากล่าสุดไปเก่าสุด
    //         usort($productsWithDates, function ($a, $b) {
    //             return strtotime($b['date']) - strtotime($a['date']);
    //         });

    //         // ดึงเฉพาะ id ที่เรียงลำดับแล้ว
    //         $sortedProductIds = array_column($productsWithDates, 'id');

    //         // ดึงผลิตภัณฑ์ที่อยู่ใน wishlist และกรองสินค้าเฉพาะที่มี id อยู่ใน sortedProductIds
    //         $products = Product::whereIn('id', $sortedProductIds)->get()->sortBy(function ($product) use ($sortedProductIds) {
    //             return array_search($product->id, $sortedProductIds);
    //         });

    //         // ดึง id_user จากตาราง products เพื่อหาผู้ขาย
    //         $sellerIds = $products->pluck('user_id')->unique(); // ดึงค่า user_id ที่ไม่ซ้ำกัน

    //         // ดึงข้อมูลผู้ขายตาม seller IDs
    //         $sellers = UserWeb::whereIn('id', $sellerIds)->get()->keyBy('id');

    //         // ส่งข้อมูลไปยัง view
    //         return view('profile.wishList', [
    //             'products' => $products,
    //             'sellers' => $sellers,
    //             'averageRating' => $averageRating,
    //         ]);
    //     } else {
    //         return view('profile.wishList', [
    //             'products' => [],
    //             'sellers' => [],
    //             'averageRating' => $averageRating,
    //         ]);
    //     }
    // }

    public function showWishlist()
    {
        $userId = auth()->id(); // รับ user_id จากการเข้าสู่ระบบ
        $cartWishList = CartWishList::where('id_user', $userId)->first();
        $user = Auth::user();

        $ratings = json_decode($user->rating, true);

        // ตรวจสอบว่าค่าของ $ratings เป็น array และไม่เป็น null
        if (is_array($ratings)) {
            $averageRating = floor(array_sum($ratings) / count($ratings));
        } else {
            $averageRating = 0;
        }

        if ($cartWishList) {
            // ตรวจสอบประเภทของ wish_list_product_ids และ add_wish_list_date
            $wishlistProductIds = is_string($cartWishList->wish_list_product_ids) ? json_decode($cartWishList->wish_list_product_ids, true) : $cartWishList->wish_list_product_ids;
            $wishlistDates = is_string($cartWishList->add_wish_list_date) ? json_decode($cartWishList->add_wish_list_date, true) : $cartWishList->add_wish_list_date;

            // ตรวจสอบว่าตัวแปรเหล่านี้ไม่เป็น null และมีค่าเป็น array
            $wishlistProductIds = is_array($wishlistProductIds) ? $wishlistProductIds : [];
            $wishlistDates = is_array($wishlistDates) ? $wishlistDates : [];

            // ตรวจสอบความยาวของ $wishlistDates ต้องตรงกับ $wishlistProductIds
            if (count($wishlistProductIds) !== count($wishlistDates)) {
                // ถ้าไม่ตรงกันให้ทำให้ $wishlistDates เป็น array ว่าง
                $wishlistDates = [];
            }

            // รวม id ของสินค้า วันที่ เพื่อการเรียงลำดับ
            $productsWithDates = array_map(function ($id, $date) {
                return ['id' => $id, 'date' => $date];
            }, $wishlistProductIds, $wishlistDates);

            // เรียงลำดับตาม add_wish_list_date จากล่าสุดไปเก่าสุด
            usort($productsWithDates, function ($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });

            // ดึงเฉพาะ id ที่เรียงลำดับแล้ว
            $sortedProductIds = array_column($productsWithDates, 'id');

            // ดึงผลิตภัณฑ์ที่อยู่ใน wishlist และกรองสินค้าเฉพาะที่มี id อยู่ใน sortedProductIds
            $products = Product::whereIn('id', $sortedProductIds)->get()->sortBy(function ($product) use ($sortedProductIds) {
                return array_search($product->id, $sortedProductIds);
            });

            // ดึง id_user จากตาราง products เพื่อหาผู้ขาย
            $sellerIds = $products->pluck('user_id')->unique(); // ดึงค่า user_id ที่ไม่ซ้ำกัน

            // ดึงข้อมูลผู้ขายตาม seller IDs
            $sellers = UserWeb::whereIn('id', $sellerIds)->get()->keyBy('id');

            // ส่งข้อมูลไปยัง view
            return view('profile.wishList', [
                'products' => $products,
                'sellers' => $sellers,
                'averageRating' => $averageRating,
            ]);
        } else {
            return view('profile.wishList', [
                'products' => [],
                'sellers' => [],
                'averageRating' => $averageRating,
            ]);
        }
    }
}
