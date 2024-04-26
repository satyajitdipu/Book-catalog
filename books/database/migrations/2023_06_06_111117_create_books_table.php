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
        Schema::create('books', function (Blueprint $table) {
            $table->id('book_id')->unique();
            $table->string('book_name');
            $table->string('genre');
            $table->string('price');
            $table->string('main_img',300);
            $table->string('isbn');
            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('author_id')->on('authors');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
