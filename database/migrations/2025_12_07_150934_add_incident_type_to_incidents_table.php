<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('incidents', function (Blueprint $table) {
        $table->unsignedBigInteger('incident_type_id')->nullable()->after('incident_name');

        $table->foreign('incident_type_id')
              ->references('id')
              ->on('incident_types')
              ->onDelete('set null');
    });
}

public function down()
{
    Schema::table('incidents', function (Blueprint $table) {
        $table->dropForeign(['incident_type_id']);
        $table->dropColumn('incident_type_id');
    });
}

};
