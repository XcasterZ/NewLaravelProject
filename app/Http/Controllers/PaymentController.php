<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;  // เพิ่ม import นี้
use Illuminate\Support\Facades\Storage;  // เพิ่มการจัดการไฟล์

class PaymentController extends Controller
{
    public function update(Request $request)
    { 
        $request->validate([
            'bank_name' => 'nullable|required_with:account_number,account_name|string|max:255',
            'account_number' => [
                'nullable',
                'required_with:bank_name,account_name',
                'string',
                'regex:/^[0-9]{10,12}$/'
            ],
            'account_name' => 'nullable|required_with:bank_name,account_number|string|max:255',
            'truewallet_phone' => [
                'nullable',
                'string',
                'regex:/^0[0-9]{9}$/'
            ],
            'qr_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',  // การตรวจสอบไฟล์อัพโหลด
        ], [
            'required_with' => 'กรุณากรอกข้อมูล :attribute ให้ครบถ้วน',
            'regex' => ':attribute ต้องเป็นตัวเลขและมีความยาวตามที่กำหนด',
            'qr_image.image' => 'กรุณาเลือกไฟล์รูปภาพ',
            'qr_image.mimes' => 'รองรับไฟล์ภาพประเภท jpg, jpeg, png, gif เท่านั้น',
            'qr_image.max' => 'ขนาดไฟล์ต้องไม่เกิน 2MB',
        ]);

        try {
            // เริ่มทำการจัดการไฟล์ qr_image หากมีการอัพโหลด
            $data = $request->only(['bank_name', 'account_number', 'account_name', 'truewallet_phone']);

            if ($request->hasFile('qr_image')) {
                // อัพโหลดไฟล์และเก็บ path
                $filePath = $request->file('qr_image')->store('qr', 'public');
                $data['qr_image'] = $filePath;  // เก็บ path ของไฟล์ในฐานข้อมูล
            }

            // อัพเดทหรือสร้างข้อมูลใหม่
            Payment::updateOrCreate(
                ['user_web_id' => auth()->id()],
                $data
            );

            return redirect()->back()->with('status', 'บันทึกข้อมูลสำเร็จ');
        } catch (\Exception $e) {
            Log::error('Payment update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
        }
    }

    // public function deleteQrImage()
    // {
    //     try {
    //         $payment = Payment::where('user_web_id', auth()->id())->first();

    //         if ($payment && $payment->qr_image) {
    //             // ลบไฟล์จาก storage
    //             Storage::disk('public')->delete($payment->qr_image);

    //             // ลบข้อมูลในฐานข้อมูล
    //             $payment->update(['qr_image' => null]);

    //             return redirect()->back()->with('status', 'ลบรูปภาพสำเร็จ');
    //         }

    //         return redirect()->back()->with('error', 'ไม่พบรูปภาพที่ต้องการลบ');
    //     } catch (\Exception $e) {
    //         Log::error('Delete QR image failed: ' . $e->getMessage());
    //         return redirect()->back()->with('error', 'เกิดข้อผิดพลาดในการลบรูปภาพ');
    //     }
    // }

    public function show()
    {
        $user = Auth::user();
        $payment = Payment::where('user_web_id', auth()->id())->first();

        // คำนวณ rating เฉลี่ย
        $ratings = json_decode($user->rating, true);
        $averageRating = is_array($ratings) ? floor(array_sum($ratings) / count($ratings)) : 0;

        return view('profile.payment', compact('payment', 'averageRating'));
    }
}
