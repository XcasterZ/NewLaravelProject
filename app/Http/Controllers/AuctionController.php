<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Log; // เพิ่มการ import Log
use Illuminate\Support\Facades\DB;  // เพิ่มบรรทัดนี้

class AuctionController extends Controller
{
    public function bid(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'top_price' => 'required|numeric|min:0',
        ]);

        // ตรวจสอบว่าผู้ใช้ล็อกอินอยู่
        $winnerId = Auth::id();
        if (!$winnerId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            // เริ่ม transaction
            DB::beginTransaction();

            // ค้นหาการประมูลที่มีอยู่แล้ว
            $auction = Auction::where('product_id', $request->product_id)->first();
            $product = Product::findOrFail($request->product_id);

            // ถ้ายังไม่มีการประมูล
            if (!$auction) {
                $auction = Auction::create([
                    'product_id' => $request->product_id,
                    'top_price' => $request->top_price,
                    'winner' => $winnerId,
                ]);

                // อัพเดตราคาในตาราง products
                $product->price = $request->top_price;
                $product->save();

                DB::commit();
                return response()->json(['message' => 'ทำการประมูลเรียบร้อยแล้ว', 'auction' => $auction], 201);            } else {
                // ถ้ามีการประมูลอยู่แล้ว ให้เช็คราคาสูงสุด
                if ($request->top_price > $auction->top_price) {
                    $auction->top_price = $request->top_price;
                    $auction->winner = $winnerId;
                    $auction->save();

                    // อัพเดตราคาในตาราง products
                    $product->price = $request->top_price;
                    $product->save();

                    DB::commit();
                    return response()->json(['message' => 'อัพเดทการประมูลเรียบร้อยแล้ว', 'auction' => $auction], 200);
                } else {
                    DB::rollBack();
                    return response()->json(['message' => 'ราคาที่เสนอต้องสูงกว่าราคาปัจจุบัน'], 400);
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bid error: ' . $e->getMessage());
            return response()->json(['message' => 'เกิดข้อผิดพลาดในระหว่างการประมูล กรุณาลองใหม่อีกครั้ง'], 500);        }
    }


    public function getCurrentPrice($id)
    {
        $auction = Auction::where('product_id', $id)->first();
        return response()->json($auction);
    }


}
