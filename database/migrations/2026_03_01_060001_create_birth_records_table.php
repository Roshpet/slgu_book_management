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
        Schema::create('birth_records', function (Blueprint $table) {
            $table->id();
            $table->string('book_number');
            $table->string('page_number');
            $table->string('registration_number')->unique(); // This was the missing column in your error
            $table->date('date_of_registration');
            $table->string('full_name');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->string('nationality');
            $table->string('name_of_mother');
            $table->string('name_of_father');
            $table->string('place_of_marriage')->nullable(); // Set to nullable as requested
            $table->date('date_of_marriage')->nullable();   // Set to nullable as requested
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
        Schema::dropIfExists('birth_records');
    }
};
