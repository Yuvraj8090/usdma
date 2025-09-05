<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // State name
            $table->boolean('is_active')->default(true); // Active/Inactive
            $table->softDeletes();                // Soft delete column (deleted_at)
            $table->timestamps();                 // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
