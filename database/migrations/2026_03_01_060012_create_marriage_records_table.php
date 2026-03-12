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
        Schema::create('marriage_records', function (Blueprint $table) {
            $table->id();
            $table->string('book_number');
            $table->string('page_number');
            $table->string('registration_number')->unique();
            $table->date('date_of_registration');
            $table->string('husband_name');
            $table->string('wife_name');
            $table->string('place_of_birth_husband');
            $table->string('place_of_birth_wife');
            $table->date('dob_husband');
            $table->date('dob_wife');
            $table->string('nationality_husband');
            $table->string('nationality_wife');
            $table->string('mother_husband');
            $table->string('father_husband');
            $table->string('mother_wife');
            $table->string('father_wife');
            $table->string('place_of_marriage');
            $table->date('date_of_marriage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marriage_records');
    }
};
