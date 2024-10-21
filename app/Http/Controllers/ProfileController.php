<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\CartWishList;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\UserWeb;



class ProfileController extends Controller
{
    public function add_item()
    {
        return view('profile.add_item');
    }

    public function edit()
    {
        $user = Auth::user(); // ดึงข้อมูลของผู้ใช้ที่ล็อกอินอยู่

        return view('profile.profile', compact('user')); // ส่งข้อมูลไปยัง view
    }

    public function update(Request $request)
    {
        // Validate and update logic here

        // Redirect after update
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully');
    }

    public function editAddress()
    {
        $user = Auth::user(); // ดึงข้อมูลผู้ใช้ที่ล็อกอินอยู่
        $address = Address::where('user_id', $user->id)->first(); // ดึงข้อมูลที่อยู่ของผู้ใช้

        $ratings = json_decode($user->rating, true);

        // ตรวจสอบว่าค่าของ $ratings เป็น array และไม่เป็น null
        if (is_array($ratings)) {
            $averageRating = floor(array_sum($ratings) / count($ratings));
        } else {
            $averageRating = 0;
        }

        return view('profile.address', compact('user', 'address', 'averageRating')); // ส่งข้อมูลไปยัง view
    }

    public function updateAddress(Request $request)
    {
        $request->validate([
            'province' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'subdistrict' => 'required|string|max:255',
            'post_code' => 'required|string|max:10',
            'additional_details' => 'nullable|string',
        ]);

        $user = Auth::user();
        $userId = $user->id; // หรือใช้ข้อมูลที่เหมาะสมจาก user_webs

        $address = Address::updateOrCreate(
            ['user_id' => $userId],
            [
                'province' => $request->province,
                'district' => $request->district,
                'subdistrict' => $request->subdistrict,
                'post_code' => $request->post_code,
                'additional_details' => $request->additional_details,
            ]
        );

        return redirect()->route('profile.address')->with('status', 'อัพเดตที่อยู่สำเร็จ');
    }


    public function showCart()
    {
        $userId = auth()->user()->id; // ใช้ id ผู้ใช้ที่ล็อกอินอยู่
        $cart = CartWishList::where('id_user', $userId)->first(); // ใช้ id_user ในการค้นหา
        $user = Auth::user();

        $ratings = json_decode($user->rating, true);

        // ตรวจสอบว่าค่าของ $ratings เป็น array และไม่เป็น null
        if (is_array($ratings)) {
            $averageRating = floor(array_sum($ratings) / count($ratings));
        } else {
            $averageRating = 0;
        }

        if ($cart) {
            // ตรวจสอบประเภทของ cart_product_ids และ add_cart_date
            $productIds = is_string($cart->cart_product_ids) ? json_decode($cart->cart_product_ids, true) : $cart->cart_product_ids;
            $cartDates = is_string($cart->add_cart_date) ? json_decode($cart->add_cart_date, true) : $cart->add_cart_date;
            // ตรวจสอบประเภทของ cart_product_quantities
            $productQuantities = is_string($cart->cart_product_quantities) ? json_decode($cart->cart_product_quantities, true) : $cart->cart_product_quantities;

            // รวม id ของสินค้า วันที่ และจำนวน เพื่อการเรียงลำดับ
            $productsWithDates = array_map(function ($id, $date, $quantity) {
                return ['id' => $id, 'date' => $date, 'quantity' => $quantity];
            }, $productIds, $cartDates, $productQuantities);

            // เรียงลำดับตาม add_cart_date จากล่าสุดไปเก่าสุด
            usort($productsWithDates, function ($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });

            // ดึงเฉพาะ id, quantity ที่เรียงลำดับแล้ว
            $sortedProductIds = array_column($productsWithDates, 'id');
            $sortedProductQuantities = array_combine($sortedProductIds, array_column($productsWithDates, 'quantity'));

            // ดึงผลิตภัณฑ์ที่อยู่ใน cart และกรองสินค้าเฉพาะที่มี id อยู่ใน cart_product_ids ที่เรียงลำดับแล้ว
            $products = Product::whereIn('id', $sortedProductIds)->get()->sortBy(function ($product) use ($sortedProductIds) {
                return array_search($product->id, $sortedProductIds);
            });

            // ดึง id_user จากตาราง products เพื่อหาผู้ขาย
            $sellerIds = $products->pluck('user_id')->unique(); // ดึงค่า user_id ที่ไม่ซ้ำกัน

            // ดึงข้อมูลผู้ขายตาม seller IDs
            $sellers = UserWeb::whereIn('id', $sellerIds)->get()->keyBy('id');



            // ส่งข้อมูลไปยัง view
            return view('profile.cart', [
                'products' => $products,
                'productQuantities' => $sortedProductQuantities,
                'sellers' => $sellers,
                'averageRating' => $averageRating, // ส่งค่า averageRating

            ]);
        } else {
            return view('profile.cart', [
                'products' => [],
                'productQuantities' => [],
                'sellers' => [],
                'averageRating' => $averageRating, // ส่งค่า averageRating

            ]);
        }
    }


    public function showRateStar($id, $product_id, $source)
    {
        $user = UserWeb::findOrFail($id);

        if (!$user) {
            abort(404);
        }

        // คำนวณคะแนนเฉลี่ย
        $ratings = json_decode($user->rating, true);

        // ตรวจสอบว่าค่าของ $ratings เป็น array และไม่เป็น null
        if (is_array($ratings)) {
            $averageRating = floor(array_sum($ratings) / count($ratings));
        } else {
            $averageRating = 0;
        }

        return view('rate_star', compact('user', 'product_id', 'source', 'averageRating'));
    }



    public function submitRating(Request $request, $id)
    {
        try {
            // ตรวจสอบความถูกต้องของข้อมูลที่ส่งเข้ามา
            $request->validate([
                'rating' => 'required|integer|between:1,5',
            ]);

            // ค้นหาผู้ใช้โดยใช้ ID
            $user = UserWeb::findOrFail($id);

            // ดึงคะแนนที่มีอยู่หรือเริ่มต้นใหม่
            $ratings = $user->rating ? json_decode($user->rating, true) : [];

            // ดึง ID ของผู้ใช้ที่ล็อกอิน
            $currentUserId = Auth::id();

            // อัปเดตคะแนนของผู้ใช้ในอาเรย์
            $ratings[$currentUserId] = $request->input('rating');

            // บันทึกคะแนนที่อัปเดตในฐานข้อมูล
            $user->rating = json_encode($ratings);
            $user->save();

            // คำนวณคะแนนเฉลี่ย
            $averageRating = count($ratings) > 0 ? array_sum($ratings) / count($ratings) : 0;

            return response()->json(['success' => true, 'averageRating' => $averageRating]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
