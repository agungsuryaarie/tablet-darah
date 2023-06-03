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
        Schema::create('sekolah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('puskesmas_id')->nullable();
            $table->string('npsn');
            $table->string('sekolah');
            $table->string('jenjang');
            $table->string('status');
            $table->string('alamat_jalan');
            $table->string('lintang');
            $table->string('bujur');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah');
    }
};
