<?php
    
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Boat, JCB, etc.
            $table->string('type')->nullable(); 
            $table->unsignedBigInteger('district_id')->nullable();
            $table->integer('quantity')->default(0);
            $table->text('remarks')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('district_id')->references('id')->on('districts')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('equipments');
    }
};
