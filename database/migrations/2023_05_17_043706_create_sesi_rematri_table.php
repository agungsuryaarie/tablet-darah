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
        Schema::create('sesi_rematri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sesi_id');
            $table->unsignedBigInteger('kelas_id');
            $table->unsignedBigInteger('rematri_id');
            $table->string('foto')->nullable();
            $table->foreign('sesi_id')->references('id')->on('sesi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi_rematri');
    }
};
