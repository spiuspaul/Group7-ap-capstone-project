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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id('equipment_id');
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
            $table->string('name');
            $table->string('capabilities')->nullable(); // CSV or JSON string
            $table->text('description')->nullable();
            $table->string('inventory_code')->nullable();
            $table->string('usage_domain')->nullable();
            $table->string('support_phase')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
