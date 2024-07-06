<?php

use App\Enums\ResolutionStatus;
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
        Schema::create('resolutions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('tag');
            $table->integer('year')->index();
            $table->longText('text');
            $table->enum('status', array_map(fn ($case) => $case->value, ResolutionStatus::cases()))->default(ResolutionStatus::Draft);
            $table->foreignUuid('category_id')->constrained()->restrictOnDelete();
            $table->foreignUuid('council_id')->constrained()->restrictOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resolutions');
    }
};
