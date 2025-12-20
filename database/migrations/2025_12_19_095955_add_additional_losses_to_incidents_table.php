<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incidents', function (Blueprint $table) {

            // Agriculture & Infrastructure Loss
            $table->decimal('agriculture_land_loss_hectare', 10, 2)->nullable()->after('file_path');
            $table->integer('helicopter_sorties')->nullable();

            // Utility damages
            $table->boolean('electricity_line_damage')->nullable(); // Vidyut line ki shati
            $table->boolean('water_pipeline_damage')->nullable();    // Pey jal line se shati

            // Animal & Hut Loss
            $table->integer('hut_count')->nullable();
            $table->integer('hen_count')->nullable();
            $table->integer('other_animal_count')->nullable();

            // Road & Rehabilitation
            $table->boolean('road_damage')->nullable();
            $table->text('punha_sthapanna_road')->nullable(); // Rehabilitation details
        });
    }

    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn([
                'agriculture_land_loss_hectare',
                'helicopter_sorties',
                'electricity_line_damage',
                'water_pipeline_damage',
                'hut_count',
                'hen_count',
                'other_animal_count',
                'road_damage',
                'punha_sthapanna_road',
            ]);
        });
    }
};
