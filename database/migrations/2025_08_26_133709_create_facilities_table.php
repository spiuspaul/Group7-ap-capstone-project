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
        Schema::create('facilities', function (Blueprint $table) {
            $table->id(); // FacilityId
            $table->string('name');
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('partner_organization')->nullable();
            $table->string('facility_type')->nullable();
            $table->string('capabilities')->nullable(); // CSV or JSON string
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
