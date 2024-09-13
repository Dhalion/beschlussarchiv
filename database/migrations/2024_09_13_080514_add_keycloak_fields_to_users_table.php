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
            $table->string('keycloak_id')->nullable()->unique()->after('id');
            $table->string('keycloak_token', 500)->nullable()->after('keycloak_id');
            $table->string('keycloak_refresh_token', 500)->nullable()->after('keycloak_token');
            // make password nullable
            $table->string('password')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('keycloak_id');
            $table->dropColumn('keycloak_token');
            $table->dropColumn('keycloak_refresh_token');
            // make password not nullable
            $table->string('password')->nullable(false)->change();
        });
    }
};
