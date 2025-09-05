<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dhams', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Dham name
            $table->boolean('is_active')->default(true); // Active or not
            $table->boolean('is_winter')->default(false); // Is it winter dham?
            $table->decimal('latitude', 10, 7)->nullable(); // Lat (e.g. 30.1234567)
            $table->decimal('longitude', 10, 7)->nullable(); // Long
            $table->integer('height')->nullable(); // Height in meters
            $table->timestamps();
            $table->softDeletes(); // Optional if you want soft delete
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dhams');
    }
};
