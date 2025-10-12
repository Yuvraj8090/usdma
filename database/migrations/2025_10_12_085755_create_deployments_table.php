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
        Schema::create('deployments', function (Blueprint $table) {
            $table->id();
            $table->morphs('deployable'); // equipment, manpower, relief
            $table->unsignedBigInteger('district_id')->nullable();
            $table->string('location'); // where deployed
            $table->date('deployed_at')->nullable();
            $table->date('returned_at')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('district_id')->references('id')->on('districts')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('deployments');
    }
};
