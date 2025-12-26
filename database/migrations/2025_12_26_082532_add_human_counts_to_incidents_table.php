<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->integer('dead_human_count')->default(0)->after('hen_count');
            $table->integer('injured_human_count')->default(0)->after('dead_human_count');
            $table->integer('missing_human_count')->default(0)->after('injured_human_count');
        });
    }

    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn([
                'dead_human_count',
                'injured_human_count',
                'missing_human_count'
            ]);
        });
    }
};

