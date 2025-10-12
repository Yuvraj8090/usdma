<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('manpowers', function (Blueprint $table) {
            // Drop old columns only if they exist
            if (Schema::hasColumn('manpowers', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('manpowers', 'designation')) {
                $table->dropColumn('designation');
            }
            if (Schema::hasColumn('manpowers', 'contact')) {
                $table->dropColumn('contact');
            }
            if (Schema::hasColumn('manpowers', 'status')) {
                $table->dropColumn('status');
            }

            // Add new structure (only if not already there)
            if (!Schema::hasColumn('manpowers', 'category')) {
                $table->string('category')->after('id');
            }
            if (!Schema::hasColumn('manpowers', 'district_id')) {
                $table->unsignedBigInteger('district_id')->after('category');
                $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            }
            if (!Schema::hasColumn('manpowers', 'count')) {
                $table->integer('count')->default(0)->after('district_id');
            }
            if (!Schema::hasColumn('manpowers', 'remarks')) {
                $table->text('remarks')->nullable()->after('count');
            }
        });
    }

    public function down(): void
    {
        Schema::table('manpowers', function (Blueprint $table) {
            // Rollback new cols
            if (Schema::hasColumn('manpowers', 'district_id')) {
                $table->dropForeign(['district_id']);
            }
            $table->dropColumn(['category', 'district_id', 'count', 'remarks']);

            // Re-add old cols
            $table->string('name');
            $table->string('designation');
            $table->string('contact', 50);
            $table->enum('status', ['active', 'inactive'])->default('active');
        });
    }
};
