<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('daily_report_files', function (Blueprint $table) {
            $table->unsignedTinyInteger('report_type')
                  ->default(1)
                  ->comment('1 = Morning, 2 = Evening')
                  ->after('file_path');
        });
    }

    public function down()
    {
        Schema::table('daily_report_files', function (Blueprint $table) {
            $table->dropColumn('report_type');
        });
    }
};
