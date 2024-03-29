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
        Schema::table('sesi_rematri', function (Blueprint $table) {
            $table->string('ruangan_id')->after('sesi_id')->nullable();
            $table->string('kelas_id')->nullable()->change();
        });
    }

    /**
     *
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sesi_rematri', function (Blueprint $table) {
            //
        });
    }
};
