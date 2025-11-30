<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('animal_losses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('incident_id')->constrained()->onDelete('cascade');
        $table->integer('big_animals')->default(0);
        $table->integer('small_animals')->default(0);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_losses');
    }
};
