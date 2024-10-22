<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionTable extends Migration
{
    public function up()
    {
        Schema::create('auction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id') // ใช้ foreignId เพื่อสร้างคอลัมน์ product_id
                  ->constrained('products') // ตั้งค่าการอ้างอิงไปยังตาราง products
                  ->onDelete('cascade'); // ลบข้อมูลในตาราง auction ถ้าลบข้อมูลในตาราง products
            
            $table->decimal('top_price', 10, 2); // ราคาสูงสุด
            $table->foreignId('winner')->nullable() // ใช้ foreignId สำหรับ winner
                  ->constrained('user_webs') // ตั้งค่าการอ้างอิงไปยังตาราง user_webs
                  ->onDelete('set null'); // ตั้งค่า winner เป็น null เมื่อผู้ใช้ถูกลบ

            $table->timestamps(0); // เก็บ created_at และ updated_at แบบเสี้ยววิ
        });
    }

    public function down()
    {
        Schema::dropIfExists('auction');
    }
}
