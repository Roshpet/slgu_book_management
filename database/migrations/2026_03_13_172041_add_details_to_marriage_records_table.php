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
            // Spouse Ages
            $table->integer('age_husband')->after('husband_name')->nullable();
            $table->integer('age_wife')->after('wife_name')->nullable();

            // Parent Nationalities - Husband
            $table->string('father_nationality_husband')->after('father_husband')->default('Filipino');
            $table->string('mother_nationality_husband')->after('mother_husband')->default('Filipino');

            // Parent Nationalities - Wife
            $table->string('father_nationality_wife')->after('father_wife')->default('Filipino');
            $table->string('mother_nationality_wife')->after('mother_wife')->default('Filipino');
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
            $table->dropColumn([
                'age_husband',
                'age_wife',
                'father_nationality_husband',
                'mother_nationality_husband',
                'father_nationality_wife',
                'mother_nationality_wife'
            ]);
        });
    }
};
