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
        Schema::table('doctors', function (Blueprint $table) {
            // Drop the old department column
            $table->dropColumn('department');

            // Add the new department_id column
            $table->foreignId('department_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            // Revert the changes
            $table->dropForeign(['department_id']); // Drop foreign key
            $table->dropColumn('department_id'); // Drop the new column

            // Add the old department column back
            $table->string('department'); // Recreate the old column
        });
    }
};
