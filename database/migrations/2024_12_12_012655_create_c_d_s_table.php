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
        Schema::create('c_d_s', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul CD
            $table->string('artist'); // Nama artis/band
            $table->string('publisher'); // Nama penerbit
            $table->year('release_year'); // Tahun rilis
            $table->string('genre'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_d_s');
    }
};
