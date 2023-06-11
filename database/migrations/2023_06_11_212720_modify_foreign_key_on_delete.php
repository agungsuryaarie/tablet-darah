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
            $table->foreign('rematri_id')->references('id')->on('rematri')->onDelete('cascade');
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
