<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_report_files', function (Blueprint $table) {
            $table->id();
            $table->string('file_path');   // Path of uploaded file
            $table->date('submit_date');   // Submit date
            $table->timestamps();          // created_at, updated_at
            $table->softDeletes();         // deleted_at (optional, if you want)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_report_files');
    }
};
