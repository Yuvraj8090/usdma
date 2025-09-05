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
        Schema::create('accidental_reports', function (Blueprint $table) {
            $table->id();

            // Link to Districts
            $table->foreignId('district_id')
                ->constrained('districts')
                ->onDelete('cascade');

            // Link to Accidental Reports Fillable (categories like Human, Vehicle, etc.)
            $table->foreignId('fillable_id')
                ->constrained('accidental_reports_fillable')
                ->onDelete('cascade');

            // Number of incidents
            $table->integer('count')->default(0);

            // Report date
            $table->date('report_date');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accidental_reports');
    }
};
