<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->string('payment')->nullable()->after('seller_id'); // เพิ่มคอลัมน์ payment หลัง seller_id
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropColumn('payment'); // ลบคอลัมน์ payment หาก rollback
        });
    }
};
