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
        Schema::table('rematri_sekolah', function (Blueprint $table) {
            $table->dropColumn(['jurusan_id']);
            $table->string('ruangan_id')->after('sekolah_id')->nullable();
            $table->string('kelas_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rematri_sekolah', function (Blueprint $table) {
            //
        });
    }
};
