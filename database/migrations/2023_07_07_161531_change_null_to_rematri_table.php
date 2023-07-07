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
            $table->string('nohp')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('tlp_ortu')->nullable()->change();
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