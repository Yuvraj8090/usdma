<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('incidents', function (Blueprint $table) {

            /*
            |--------------------------------------------------------------------------
            | INCIDENT TYPE
            |--------------------------------------------------------------------------
            */
            if (!Schema::hasColumn('incidents', 'incident_type_id')) {
                $table->unsignedBigInteger('incident_type_id')->nullable()->after('id');
            }

            // Drop FK if exists
            DB::statement("
                ALTER TABLE incidents
                DROP FOREIGN KEY IF EXISTS incidents_incident_type_id_foreign
            ");

            // Add FK again
            $table->foreign('incident_type_id')
                  ->references('id')
                  ->on('incident_types')
                  ->onDelete('restrict');


            /*
            |--------------------------------------------------------------------------
            | DISASTER TYPE
            |--------------------------------------------------------------------------
            */
            if (!Schema::hasColumn('incidents', 'disaster_type_id')) {
                $table->unsignedBigInteger('disaster_type_id')->nullable()->after('incident_type_id');
            }

            // Drop FK if exists
            DB::statement("
                ALTER TABLE incidents
                DROP FOREIGN KEY IF EXISTS incidents_disaster_type_id_foreign
            ");

            // Add FK again
            $table->foreign('disaster_type_id')
                  ->references('id')
                  ->on('disaster_types')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {

            $table->dropForeign(['incident_type_id']);
            $table->dropForeign(['disaster_type_id']);

            // Optional: keep columns or remove
            // $table->dropColumn(['incident_type_id', 'disaster_type_id']);
        });
    }
};
