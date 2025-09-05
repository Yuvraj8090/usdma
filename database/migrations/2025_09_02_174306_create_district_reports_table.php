<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('district_reports', function (Blueprint $table) {
            $table->id();

            // Foreign key to districts
            $table->unsignedBigInteger('district_id');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');

            // Report body
            $table->text('body');

            // Date of submission
            $table->date('submit_date')->nullable();

            // Standard Laravel timestamps + soft delete
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('district_reports');
    }
};
