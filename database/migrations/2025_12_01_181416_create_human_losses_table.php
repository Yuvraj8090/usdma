<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('human_losses', function (Blueprint $table) {
            $table->id();

            // Relationship to incidents
            $table->unsignedBigInteger('incident_id');
            $table->foreign('incident_id')->references('id')->on('incidents')->onDelete('cascade');

            // Personal details
            $table->string('name');
            $table->integer('age')->nullable();
            $table->enum('sex', ['male', 'female', 'other'])->nullable();

            // Loss type
            $table->enum('loss_type', ['died', 'missing', 'normal_damage'])->default('normal_damage');

            // Address details
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();

            // Compensation
            $table->decimal('compensation_amount', 12, 2)->nullable();
            $table->date('compensation_received_date')->nullable();
            $table->enum('compensation_status', ['pending', 'approved', 'rejected'])->default('pending');

            // Nominee JSON (name, relation, address, age, number)
            $table->json('nominee')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('human_losses');
    }
};
