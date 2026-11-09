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
        Schema::table('simulation_logs', function (Blueprint $table) {
            $table->string('auth_method', 30)->nullable()->after('cta_login_clicked');
            $table->string('masked_target', 100)->nullable()->after('auth_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('simulation_logs', function (Blueprint $table) {
            $table->dropColumn(['auth_method', 'masked_target']);
        });
    }
};
