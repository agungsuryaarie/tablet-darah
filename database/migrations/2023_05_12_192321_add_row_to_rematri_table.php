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
        Schema::table('rematri', function (Blueprint $table) {
            $table->string('agama')->after('panjang_badan');
            $table->string('jurusan_id')->nullable()->after('agama');
            $table->string('kelas_id')->nullable()->after('jurusan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rematri', function (Blueprint $table) {
            //
        });
    }
};
