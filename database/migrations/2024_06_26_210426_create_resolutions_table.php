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
            $table->string('title')->index();
            $table->string('tag')->index();
            $table->integer('year')->index();
            $table->longText('text');
            $table->enum('status', array_map(fn ($case) => $case->value, ResolutionStatus::cases()))->default(ResolutionStatus::Draft);
            $table->foreignUuid('category_id')->constrained()->restrictOnDelete()->index()->name('fk_resolutions_category_id');
            $table->foreignUuid('council_id')->constrained()->restrictOnDelete()->index()->name('fk_resolutions_council_id');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->name('fk_resolutions_created_by');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->name('fk_resolutions_updated_by');
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
