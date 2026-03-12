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
        Schema::create('death_records', function (Blueprint $table) {
            $table->id();
            $table->string('book_number');
            $table->string('page_number');
            $table->string('registration_number')->unique();
            $table->date('date_of_registration');
            $table->string('full_name');
            $table->string('place_of_birth');
            $table->date('date_of_death');
            $table->text('cause_of_death');
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
        Schema::dropIfExists('death_records');
    }
};
