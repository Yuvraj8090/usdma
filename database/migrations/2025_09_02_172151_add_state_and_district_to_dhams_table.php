<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dhams', function (Blueprint $table) {
            // Add state_id and district_id columns
            $table->unsignedBigInteger('state_id')->nullable()->after('id');
            $table->unsignedBigInteger('district_id')->nullable()->after('state_id');

            // Add foreign key constraints (optional but recommended)
            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('dhams', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['state_id']);
            $table->dropForeign(['district_id']);

            // Drop columns
            $table->dropColumn(['state_id', 'district_id']);
        });
    }
};
