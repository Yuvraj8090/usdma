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
        Schema::create('tourist_visitor_details', function (Blueprint $table) {
            $table->id();

            // 🔹 Foreign key linking to dhams.id
            $table->foreignId('location_id')->constrained('dhams')->onDelete('cascade');

            // 🔹 Data columns
            $table->string('date')->nullable();
            $table->time('reporting_time')->nullable();

            $table->integer('men')->default(0);
            $table->integer('women')->default(0);
            $table->integer('children')->default(0);
            $table->integer('foreign_men')->default(0);
            $table->integer('foreign_women')->default(0);
            $table->integer('foreign_children')->default(0);

            $table->integer('no_of_pilgrims')->default(0);
            $table->integer('no_of_vehicles')->default(0);

            // 🔹 Dead & missing info
            $table->integer('dead_due_health')->default(0);
            $table->integer('dead_due_nature')->default(0);
            $table->integer('dead_today')->default(0);

            $table->integer('missing_due_health')->default(0);
            $table->integer('missing_due_nature')->default(0);
            $table->integer('missing_today')->default(0);

            // 🔹 Till date summary
            $table->integer('pilgrims_till_date')->nullable();

            $table->integer('vehicles_till_date')->nullable();
            $table->integer('dead_till_date')->nullable();
            $table->integer('missing_till_date')->nullable();

            // 🔹 Other fields
            $table->dateTime('entry_date')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tourist_visitor_details');
    }
};
