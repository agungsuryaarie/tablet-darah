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
        Schema::create('hb', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('puskesmas_id');
            $table->unsignedBigInteger('sekolah_id');
            $table->unsignedBigInteger('rematri_id');
            $table->string('tgl_cek');
            $table->integer('berat_badan');
            $table->integer('panjang_badan');
            $table->integer('hb');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hb');
    }
};
