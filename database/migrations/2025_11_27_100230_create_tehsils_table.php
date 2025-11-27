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
        Schema::create('tehsils', function (Blueprint $table) {
            $table->id();                                 // id
            $table->string('name');                       // tehsil name
            $table->unsignedBigInteger('district_id');    // link to districts table
            $table->boolean('is_active')->default(1);     // active/inactive
            $table->softDeletes();                        // deleted_at
            $table->timestamps();                         // created_at, updated_at

            // Foreign key
            $table->foreign('district_id')
                  ->references('id')
                  ->on('districts')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tehsils');
    }
};
