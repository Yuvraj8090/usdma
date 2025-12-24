<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('equipments', function (Blueprint $table) {
            if (!Schema::hasColumn('equipments', 'activity_id')) {
                $table->foreignId('activity_id')->nullable()->after('id')->constrained('activities')->nullOnDelete();
            }

            if (!Schema::hasColumn('equipments', 'resource_type_id')) {
                $table->foreignId('resource_type_id')->nullable()->after('activity_id')->constrained('resource_types')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('equipments', function (Blueprint $table) {
            if (Schema::hasColumn('equipments', 'activity_id')) {
                $table->dropForeign(['activity_id']);
                $table->dropColumn('activity_id');
            }

            if (Schema::hasColumn('equipments', 'resource_type_id')) {
                $table->dropForeign(['resource_type_id']);
                $table->dropColumn('resource_type_id');
            }
        });
    }
};
