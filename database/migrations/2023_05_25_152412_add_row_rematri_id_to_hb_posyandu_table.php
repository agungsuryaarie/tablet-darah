<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hb_posyandu', function (Blueprint $table) {
            $table->unsignedBigInteger('rematri_id')->after('posyandu_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hb_posyandu', function (Blueprint $table) {
            //
        });
    }
};
