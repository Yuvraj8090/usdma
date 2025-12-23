<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->integer('partially_house')->default(0)->after('small_animals_died');
            $table->integer('severely_house')->default(0)->after('partially_house');
            $table->integer('fully_house')->default(0)->after('severely_house');
            $table->integer('cowshed_house')->default(0)->after('fully_house');
        });
    }

    public function down()
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn([
                'partially_house',
                'severely_house',
                'fully_house',
                'cowshed_house'
            ]);
        });
    }
};
