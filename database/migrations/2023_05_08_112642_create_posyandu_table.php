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
        Schema::create('posyandu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('desa_id');
            $table->unsignedBigInteger('puskesmas_id');
            $table->string('posyandu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandu');
    }
};
