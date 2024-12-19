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
        Schema::create('newsspapers', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Nama koran
                $table->date('publication_date'); // Tanggal terbit
                $table->String('publisher'); // Penerbit koran
                $table->timestamps();
            });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newsspapers');
    }
};
