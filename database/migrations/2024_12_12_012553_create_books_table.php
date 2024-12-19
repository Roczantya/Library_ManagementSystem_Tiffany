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
            $table->string('Judul');
            $table->string('penerbit');
            $table->string('penulis');
            $table->integer('tahun_terbit');
            $table->string('isbn')->unique();
            $table->boolean('isEbook');
            $table->string('ebookLink')->nullable();
            $table->boolean('isBorrowed');
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
