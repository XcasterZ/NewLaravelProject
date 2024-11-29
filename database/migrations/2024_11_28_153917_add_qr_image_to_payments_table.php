<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('qr_image')->nullable();  // เพิ่มฟิลด์สำหรับเก็บ path ของไฟล์
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('qr_image');  // ลบฟิลด์ qr_image ออก
        });
    }
};