<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('death_records', function (Blueprint $table) {
            // 1. Remove the unwanted column
            $table->dropColumn('place_of_birth');

            // 2. Add the new columns
            // Added after 'full_name' for better database organization
            $table->string('sex')->after('full_name');
            $table->string('nationality')->default('FILIPINO')->after('sex');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('death_records', function (Blueprint $table) {
            // Re-add place_of_birth if we rollback
            $table->string('place_of_birth')->nullable();

            // Remove the new columns
            $table->dropColumn(['sex', 'nationality']);
        });
    }
};
