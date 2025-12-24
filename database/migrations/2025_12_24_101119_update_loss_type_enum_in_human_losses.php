<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // STEP 1: Temporarily allow BOTH enum values
        DB::statement("
            ALTER TABLE human_losses 
            MODIFY loss_type 
            ENUM('died', 'missing', 'normal_damage', 'injured') 
            NOT NULL 
            DEFAULT 'normal_damage'
        ");

        // STEP 2: Update existing data
        DB::statement("
            UPDATE human_losses 
            SET loss_type = 'injured' 
            WHERE loss_type = 'normal_damage'
        ");

        // STEP 3: Remove old enum value
        DB::statement("
            ALTER TABLE human_losses 
            MODIFY loss_type 
            ENUM('died', 'missing', 'injured') 
            NOT NULL 
            DEFAULT 'injured'
        ");
    }

    public function down()
    {
        // STEP 1: Allow both again
        DB::statement("
            ALTER TABLE human_losses 
            MODIFY loss_type 
            ENUM('died', 'missing', 'normal_damage', 'injured') 
            NOT NULL 
            DEFAULT 'normal_damage'
        ");

        // STEP 2: Revert values
        DB::statement("
            UPDATE human_losses 
            SET loss_type = 'normal_damage' 
            WHERE loss_type = 'injured'
        ");

        // STEP 3: Restore original enum
        DB::statement("
            ALTER TABLE human_losses 
            MODIFY loss_type 
            ENUM('died', 'missing', 'normal_damage') 
            NOT NULL 
            DEFAULT 'normal_damage'
        ");
    }
};
