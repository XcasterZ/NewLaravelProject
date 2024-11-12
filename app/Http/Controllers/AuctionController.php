<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Facades\Log; // เพิ่มการ import Log

class AuctionController extends Controller
{
    public function bid(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'top_price' => 'required|numeric|min:0', // เพิ่ม min:0 เพื่อป้องกันราคาติดลบ
        ]);

        // ตรวจสอบว่าผู้ใช้ล็อกอินอยู่
        $winnerId = Auth::id();
        if (!$winnerId) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // ค้นหาการประมูลที่มีอยู่แล้ว
        $auction = Auction::where('product_id', $request->product_id)->first();

        // ถ้ายังไม่มีการประมูล
        if (!$auction) {
            $auction = Auction::create([
                'product_id' => $request->product_id,
                'top_price' => $request->top_price,
                'winner' => $winnerId,
            ]);
            return response()->json(['message' => 'Bid placed successfully', 'auction' => $auction], 201);
        } else {
            // ถ้ามีการประมูลอยู่แล้ว ให้เช็คราคาสูงสุด
            if ($request->top_price > $auction->top_price) {
                $auction->top_price = $request->top_price;
                $auction->winner = $winnerId;
                $auction->save();
                return response()->json(['message' => 'Bid updated successfully', 'auction' => $auction], 200);
            } else {
                return response()->json(['message' => 'Bid must be higher than the current top price.'], 400);
            }
        }
    }


    public function getCurrentPrice($id)
    {
        $auction = Auction::where('product_id', $id)->first();
        return response()->json($auction);
    }

    
}
