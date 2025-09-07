<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_reports_dhams', function (Blueprint $table) {
            $table->id();

            // Link to Dhams
            $table->foreignId('dham_id')
                  ->constrained('dhams')
                  ->onDelete('cascade');

            // Link to Daily Reports Fillable
            $table->foreignId('fillable_id')
                  ->constrained('daily_reports_fillable')
                  ->onDelete('cascade');

            $table->integer('count')->default(0);
            $table->date('report_date');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_reports_dhams');
    }
};
