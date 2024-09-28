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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code_subject');
            $table->unsignedBigInteger('classe_id'); // Foreign key to classes
            $table->integer('coef'); // Coefficient with 2 decimal places
            $table->string('teacher')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade');

            // Unique constraint for name and code_subject within the same class
            $table->unique(['name', 'code_subject', 'classe_id']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
