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
        Schema::table('equipments', function (Blueprint $table) {
            // Drop old "type" column if it exists
            if (Schema::hasColumn('equipments', 'type')) {
                $table->dropColumn('type');
            }

            // Add category_id column as foreign key
            $table->unsignedBigInteger('category_id')->after('name');

            $table->foreign('category_id')
                  ->references('id')
                  ->on('equipment_categories')
                  ->onDelete('cascade'); // If category deleted, equipment also deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipments', function (Blueprint $table) {
            // Remove foreign key first
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');

            // Re-add type column if rolled back
            $table->string('type')->nullable();
        });
    }
};
