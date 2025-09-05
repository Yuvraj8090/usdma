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
        Schema::create('media_files', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Original file name
            $table->string('file_name'); // Stored file name on disk
            $table->string('file_path'); // Storage path (relative to storage)
            $table->string('mime_type'); // File type e.g., image/png, application/pdf
            $table->unsignedBigInteger('size'); // File size in bytes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_files');
    }
};
