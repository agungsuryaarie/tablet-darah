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
        Schema::create('sesi_rematri_posyandu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesi_posyandu_id');
            $table->unsignedBigInteger('posyandu_id');
            $table->unsignedBigInteger('rematri_posyandu_id');
            $table->string('foto')->nullable();
            $table->foreign('sesi_posyandu_id')->references('id')->on('sesi_posyandu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_rematri_posyandu');
    }
};
