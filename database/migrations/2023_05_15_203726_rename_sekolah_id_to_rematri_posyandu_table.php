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
        Schema::table('rematri_posyandu', function (Blueprint $table) {
            $table->dropColumn('sekolah_id');
            $table->dropColumn('hb');
            $table->string('posyandu_id')->after('puskesmas_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rematri_posyandu', function (Blueprint $table) {
            //
        });
    }
};
