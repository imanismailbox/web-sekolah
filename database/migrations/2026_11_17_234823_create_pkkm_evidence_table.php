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
        Schema::create('pkkm_evidence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pkkm_indicator_id')->constrained()->cascadeOnDelete();
            $table->string('label')->nullable();
            $table->string('type')->default('link');
            $table->string('url', 2048)->nullable();
            $table->string('file_path')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkkm_evidence');
    }
};
