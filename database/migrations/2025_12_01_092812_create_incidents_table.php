<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();

            // Unique Incident ID
            $table->string('incident_uid')->unique();

            // Basic Details
            $table->string('incident_name');
            $table->text('steps')->nullable();
            $table->text('incident_through')->nullable();

            // Location Details
            $table->string('state');
            $table->string('district');
            $table->string('village');

            // Geo Coordinates
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();

            // Date and Time
            $table->date('incident_date');
            $table->time('incident_time');

            // Animal Count
            $table->integer('big_animals_died')->default(0);
            $table->integer('small_animals_died')->default(0);

            // File Upload
            $table->string('file_path')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('incidents');
    }
};
