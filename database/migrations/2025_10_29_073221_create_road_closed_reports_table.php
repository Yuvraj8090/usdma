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
        Schema::create('road_closed_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('fillable_id');
            $table->longText('data')->nullable(); // changed from 'count' to 'data'
            $table->date('report_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign key relationships
            $table->foreign('fillable_id')
                ->references('id')
                ->on('road_closed_fillables')
                ->onDelete('cascade');

            // (Optional) If you have a districts table
            $table->foreign('district_id')
                ->references('id')
                ->on('districts')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('road_closed_reports');
    }
};
