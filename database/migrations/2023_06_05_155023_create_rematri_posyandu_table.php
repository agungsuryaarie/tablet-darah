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
        Schema::create('rematri_posyandu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rematri_id');
            $table->unsignedBigInteger('puskesmas_id');
            $table->unsignedBigInteger('posyandu_id');
            $table->timestamps();

            $table->foreign('rematri_id')->references('id')->on('rematri');
            $table->foreign('puskesmas_id')->references('id')->on('puskesmas');
            $table->foreign('posyandu_id')->references('id')->on('posyandu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rematri_posyandu');
    }
};
