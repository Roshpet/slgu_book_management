<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('death_records', function (Blueprint $table) {
            // Check if column exists before adding to avoid "Duplicate column" errors
            if (!Schema::hasColumn('death_records', 'place_of_death')) {
                $table->string('place_of_death')->after('date_of_death');
            }
            if (!Schema::hasColumn('death_records', 'age')) {
                $table->integer('age')->after('place_of_death');
            }
            if (!Schema::hasColumn('death_records', 'civil_status')) {
                $table->string('civil_status')->after('age');
            }
            if (!Schema::hasColumn('death_records', 'occupation')) {
                $table->string('occupation')->nullable()->after('civil_status');
            }
        });
    }

    public function down()
    {
        // Keep this empty for now to stop the "Can't DROP column" error
    }
};
