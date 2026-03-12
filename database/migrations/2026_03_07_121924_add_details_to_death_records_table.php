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
        Schema::table('death_records', function (Blueprint $table) {
            $table->string('place_of_death')->after('date_of_death');
            // Add any other missing columns from your form here
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('death_records', function (Blueprint $table) {
            //
        });
    }
};
