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
        Schema::create('accidental_reports_fillable', function (Blueprint $table) {
            $table->id();

            // Parent ID for nested categories or groups
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('accidental_reports_fillable')
                ->onDelete('cascade');

            // Report type or category (e.g. Human, Vehicle, Property)
            $table->string('name')->index();

            // Description field for details
            $table->text('description')->nullable();

            // Status
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
        Schema::dropIfExists('accidental_reports_fillable');
    }
};
