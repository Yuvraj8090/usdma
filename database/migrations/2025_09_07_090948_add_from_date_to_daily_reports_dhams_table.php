<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_reports_dhams', function (Blueprint $table) {
            $table->date('from_date')->nullable()->before('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('daily_reports_dhams', function (Blueprint $table) {
            $table->dropColumn('from_date');
        });
    }
};
