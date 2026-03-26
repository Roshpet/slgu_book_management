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
            // Adding Sex after Full Name
            $table->string('sex', 10)->nullable()->after('full_name');


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
            // Drop all added columns if rolled back
            $table->dropColumn(['sex']);
        });
    }
};
