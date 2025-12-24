<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('equipments', function (Blueprint $table) {

        $table->foreignId('activity_id')
              ->nullable()
              ->after('id')
              ->constrained('activities')
              ->nullOnDelete();

        $table->foreignId('resource_type_id')
              ->nullable()
              ->after('activity_id')
              ->constrained('resource_types')
              ->nullOnDelete();
    });
}


    public function down(): void
    {
        Schema::table('equipments', function (Blueprint $table) {
            $table->dropForeign(['activity_id']);
            $table->dropForeign(['resource_type_id']);
            $table->dropColumn(['activity_id', 'resource_type_id']);
        });
    }
};
