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
        Schema::create('authors', function (Blueprint $table) {
            $table->id('author_id');
            $table->string('main_image');
            $table->string('author_name');
            $table->string('gender');
            $table->string('genre');
            $table->string('age');
            $table->string('ratings');
            $table->string('monthly_award');
            $table->string('email');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
