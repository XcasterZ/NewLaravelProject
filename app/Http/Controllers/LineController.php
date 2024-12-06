<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\UserWeb;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LineController extends Controller
{
    public function redirect()
    {
        // ส่งผู้ใช้ไปยังหน้าล็อกอินของ LINE
        return Socialite::driver('line')->redirect();
    }

    public function callback()
    {
        try {
            // รับข้อมูลผู้ใช้จาก LINE
            $lineUser = Socialite::driver('line')->stateless()->user(); // ใช้ stateless เพื่อหลีกเลี่ยงปัญหา session
            Log::info('LINE User: ', (array) $lineUser);

            // ตรวจสอบว่าข้อมูลสำคัญครบหรือไม่
            if (!$lineUser->getId()) {
                throw new \Exception('LINE ID not found.');
            }

            // สร้าง username แบบสุ่ม หากไม่มีชื่อ
            $username = preg_replace('/\s+/', '', $lineUser->getName()) ?? 'user_' . Str::random(8);

            // ตรวจสอบ username ให้ไม่ซ้ำ
            $baseUsername = $username;
            $count = 1;
            while (UserWeb::where('username', $username)->exists()) {
                $username = $baseUsername . $count; // เพิ่มเลขต่อท้าย
                $count++;
            }

            // ตรวจสอบผู้ใช้ในระบบ
            $user = UserWeb::where('line_id', $lineUser->getId())
                ->orWhere('email', $lineUser->getEmail())
                ->first();

            if (!$user) {
                // สร้างผู้ใช้ใหม่
                $user = UserWeb::create([
                    'username' => $username,
                    'email' => $lineUser->getEmail() ?: 'user_' . Str::random(8) . '@example.com', // ใช้ email placeholder หากไม่มี
                    'line_id' => $lineUser->getId(),
                    'profile_img' => $lineUser->getAvatar(),
                    'password' => bcrypt(Str::random(16)), // กำหนดรหัสผ่านแบบสุ่ม (สำรอง)
                ]);
            }

            // ล็อกอินผู้ใช้
            Auth::login($user);

            return redirect()->route('home')->with('success', 'Logged in with LINE!');
        } catch (\Exception $e) {
            Log::error('LINE login error: ' . $e->getMessage());

            return redirect()->route('login')->with('error', 'Something went wrong during LINE login. Please try again.');
        }
    }
}
