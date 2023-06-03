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
        Schema::create('users_sekolah', function (Blueprint $table) {
            $table->id();
            $table->integer('kecamatan_id');
            $table->unsignedBigInteger('puskesmas_id');
            $table->unsignedBigInteger('sekolah_id');
            $table->string('jenjang');
            $table->string('nik')->unique();
            $table->string('nama');
            $table->string('nohp');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_sekolah');
    }
};
