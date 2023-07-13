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
        Schema::create('rematri_sekolah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rematri_id');
            $table->unsignedBigInteger('puskesmas_id');
            $table->unsignedBigInteger('sekolah_id');
            $table->string('kelas_id')->nullable();
            $table->string('ruangan_id')->nullable();
            $table->timestamps();

            $table->foreign('rematri_id')->references('id')->on('rematri')->onDelete('cascade');
            $table->foreign('puskesmas_id')->references('id')->on('puskesmas');
            $table->foreign('sekolah_id')->references('id')->on('sekolah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rematri_sekolah');
    }
};
