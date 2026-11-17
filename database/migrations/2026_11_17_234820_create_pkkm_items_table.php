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
        Schema::create('pkkm_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pkkm_component_id')->constrained()->cascadeOnDelete();
            $table->string('code', 20);
            $table->text('name');
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkkm_items');
    }
};
