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
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('publisher');
            $table->year('year');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            // $table->binary('cover')->nullable(); // untuk tipe data longblob
            $table->string('cover')->nullable(); // untuk tipe data string (path)
            $table->text('description')->nullable();
            $table->enum('stock',['Available', 'Borrowed'])->default('Available');
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
