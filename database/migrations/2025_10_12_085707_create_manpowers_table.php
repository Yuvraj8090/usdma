<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void {
        Schema::create('manpowers', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // NDRF, SDRF, Fire, Police, NGOs
            $table->unsignedBigInteger('district_id')->nullable();
            $table->integer('count')->default(0);
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('district_id')->references('id')->on('districts')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('manpowers');
    }
};
