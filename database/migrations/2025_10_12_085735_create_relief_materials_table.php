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
        Schema::create('relief_materials', function (Blueprint $table) {
            $table->id();
            $table->string('item_name'); // Food, Medicine, Tents, Blankets
            $table->unsignedBigInteger('district_id')->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->string('unit')->default('pcs'); // kg, liters, pcs, etc.
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('district_id')->references('id')->on('districts')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('relief_materials');
    }   
};
