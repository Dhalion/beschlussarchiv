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
        Schema::table('councils', function (Blueprint $table) {
            $table->string('slug')->unique()->after('shortName')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('councils', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
