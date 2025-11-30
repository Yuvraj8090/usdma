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
    Schema::create('compensations', function (Blueprint $table) {
        $table->id();
        $table->foreignId('incident_id')->constrained()->onDelete('cascade');
        $table->enum('compensation_type', ['death','injured','missing','property_loss','animal_loss']);
        $table->enum('status', ['pending','approved','released'])->default('pending');
        $table->date('release_date')->nullable();
        $table->decimal('amount', 10, 2)->default(0);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compensations');
    }
};
