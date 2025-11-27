<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('villages', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Linking to tehsils
            $table->unsignedBigInteger('tehsil_id');

            // Linking to district (optional but recommended)
            $table->unsignedBigInteger('district_id');

            // Status
            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('tehsil_id')->references('id')->on('tehsils')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('villages');
    }
};
