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
        Schema::table('users', function (Blueprint $table) {
            $table->string('no_hp', 20)->nullable()->default('text')->after('password');
            $table->string('alamat', 255)->nullable()->default('text')->after('no_hp');
            $table->string('foto_profil', 255)->nullable()->default('text')->after('alamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('no_hp');
            $table->dropColumn('alamat');
            $table->dropColumn('foto_profil');
        });
    }
};
