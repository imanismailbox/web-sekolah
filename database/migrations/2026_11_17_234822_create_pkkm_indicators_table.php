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
        Schema::create('pkkm_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pkkm_item_id')->constrained()->cascadeOnDelete();
            $table->string('number', 10)->nullable();
            $table->text('description');
            $table->text('expected_evidence')->nullable();
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkkm_indicators');
    }
};
