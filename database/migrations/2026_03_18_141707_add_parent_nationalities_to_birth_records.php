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
        Schema::table('birth_records', function (Blueprint $table) {
            // Adding nationalities with a default value of 'FILIPINO'
            $table->string('mother_nationality')->default('FILIPINO')->after('name_of_mother');
            $table->string('father_nationality')->default('FILIPINO')->after('name_of_father');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('birth_records', function (Blueprint $table) {
            // Dropping the columns if the migration is rolled back
            $table->dropColumn(['mother_nationality', 'father_nationality']);
        });
    }
};
