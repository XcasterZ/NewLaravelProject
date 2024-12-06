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
        Schema::table('user_webs', function (Blueprint $table) {
            $table->string('line_id')->nullable()->after('google_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('user_webs', function (Blueprint $table) {
            $table->dropColumn('line_id');
        });
    }
};
