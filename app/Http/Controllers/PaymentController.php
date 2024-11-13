<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;  // เพิ่ม import นี้

class PaymentController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'nullable|string|max:255',
            'account_number' => [
                'nullable',
                'string',
                'regex:/^[0-9]{10,12}$/'
            ],
            'account_name' => 'nullable|string|max:255',
            'truewallet_phone' => [
                'nullable',
                'string',
                'regex:/^0[0-9]{9}$/'
            ],
        ]);

        try {
            // อัพเดทหรือสร้างข้อมูลใหม่โดยใช้ user_web_id
            Payment::updateOrCreate(
                ['user_web_id' => auth()->id()],
                $validated
            );

            return redirect()->back()->with('status', 'บันทึกข้อมูลสำเร็จ');
        } catch (\Exception $e) {
            Log::error('Payment update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
        }
    }

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
