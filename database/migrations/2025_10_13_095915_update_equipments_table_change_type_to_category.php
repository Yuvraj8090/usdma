<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

            // Only add category_id if it does NOT exist
            if (!Schema::hasColumn('equipments', 'category_id')) {
                $table->unsignedBigInteger('category_id')->after('name');

                $table->foreign('category_id')
                    ->references('id')
                    ->on('equipment_categories')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipments', function (Blueprint $table) {
            // Drop foreign key only if column exists
            if (Schema::hasColumn('equipments', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }

            // Re-add type column if needed
            if (!Schema::hasColumn('equipments', 'type')) {
                $table->string('type')->nullable();
            }
        });
    }
};
