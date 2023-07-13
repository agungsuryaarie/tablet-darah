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
        Schema::create('rematri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('desa_id');
            $table->string('nokk');
            $table->string('nik')->unique();
            $table->string('nama');
            $table->string('nohp')->nullable();
            $table->string('email')->nullable();
            $table->string('tempat_lahir');
            $table->string('tgl_lahir');
            $table->integer('anak_ke');
            $table->integer('berat_badan');
            $table->integer('panjang_badan');
            $table->string('agama');
            $table->string('nama_ortu');
            $table->string('nik_ortu');
            $table->string('tlp_ortu')->nullable();
            $table->string('alamat');
            $table->timestamps();

            $table->foreign('kecamatan_id')->references('id')->on('kecamatan');
            $table->foreign('desa_id')->references('id')->on('desa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rematri');
    }
};
