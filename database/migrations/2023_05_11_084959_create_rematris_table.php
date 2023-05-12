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
            $table->string('puskesmas_id');
            $table->string('sekolah_id');
            $table->integer('anak_ke');
            $table->string('tempat_lahir');
            $table->date('tgl_lahir');
            $table->string('nokk');
            $table->string('nik')->unique();
            $table->string('nama');
            $table->integer('berat_badan');
            $table->integer('panjang_badan');
            $table->integer('hb')->nullable();
            $table->string('nama_ortu');
            $table->string('nik_ortu');
            $table->string('tlp_ortu');
            $table->string('kecamatan_id');
            $table->string('desa_id');
            $table->string('alamat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rematris');
    }
};
