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
            $table->string('kecamatan_id');
            $table->string('desa_id');
            $table->unsignedBigInteger('puskesmas_id');

            $table->unsignedBigInteger('sekolah_id');
            $table->string('jurusan_id')->nullable();
            $table->string('kelas_id');

            $table->string('nokk');
            $table->string('nik')->unique();
            $table->string('nama');
            $table->string('nohp');
            $table->string('email')->unique();
            $table->string('tempat_lahir');
            $table->string('tgl_lahir');
            $table->integer('anak_ke');
            $table->integer('berat_badan');
            $table->integer('panjang_badan');
            $table->string('agama');
            $table->string('nama_ortu');
            $table->string('nik_ortu');
            $table->string('tlp_ortu');
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
