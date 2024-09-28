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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique();
            $table->string('first_name')->unique();
            $table->string('last_name')->nullable();
            $table->enum('sex', ['male', 'female']);
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('nationality')->nullable();
            $table->string('parents_contact')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('classe_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
