<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->date('date'); // Date of meeting
            $table->time('time'); // Time of meeting
            $table->string('meeting_location'); // Meeting location
            $table->string('topic'); // Topic
            $table->string('abhiyoukti')->nullable(); // Abhiyoukti column
            $table->string('file_url')->nullable(); // File upload column
            $table->string('meeting_url')->nullable(); // Meeting URL column
            $table->timestamps(); // Created_at & updated_at
            $table->softDeletes(); // Soft delete column
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
