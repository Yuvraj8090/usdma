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
        Schema::create('natural_disaster_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->unsignedBigInteger('fillable_id')->nullable();
            $table->integer('count')->default(0);
            $table->date('report_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('district_id')
                ->references('id')
                ->on('districts')
                ->onDelete('set null');

            $table->foreign('fillable_id')
                ->references('id')
                ->on('natural_disaster_reports_fillable')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('natural_disaster_reports');
    }
};
