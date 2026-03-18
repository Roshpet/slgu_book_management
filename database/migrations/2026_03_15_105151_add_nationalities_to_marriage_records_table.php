<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('marriage_records', function (Blueprint $table) {
            // Adding the new nationality fields
            $table->string('nationality_husband')->default('Filipino')->after('age_husband');
            $table->string('nationality_wife')->default('Filipino')->after('age_wife');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('marriage_records', function (Blueprint $table) {
            // Dropping the columns if the migration is rolled back
            $table->dropColumn(['nationality_husband', 'nationality_wife']);
        });
    }
};
