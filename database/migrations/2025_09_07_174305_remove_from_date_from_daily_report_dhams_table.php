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
        Schema::table('daily_report_dhams', function (Blueprint $table) {
            if (Schema::hasColumn('daily_report_dhams', 'from_date')) {
                $table->dropColumn('from_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daily_report_dhams', function (Blueprint $table) {
            $table->date('from_date')->nullable();
        });
    }
};
