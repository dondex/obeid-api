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
        Schema::table('users', function (Blueprint $table) {
            $table->string('patient_id', 7)->unique(); // Random 7 Digits
            $table->string('full_name'); // Full Name
            $table->string('resident_number'); // Resident Number
            $table->string('phone_number'); // Phone Number
            $table->date('birthday'); // Birthday
            $table->boolean('insurance')->default(false); // Insurance (Yes or No)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['patient_id', 'full_name', 'resident_number', 'phone_number', 'birthday', 'insurance']);
        });
    }
};
