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
    Schema::create('incidents', function (Blueprint $table) {
        $table->id();
        $table->enum('incident_type', ['human', 'animal', 'property']);
        $table->string('name');
        $table->string('gender')->nullable();
        $table->integer('age')->nullable();
        $table->date('date');
        $table->time('time');
        $table->string('state');
        $table->text('address');
        $table->json('loss_details')->nullable(); // flexible storage
        $table->text('reason')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
