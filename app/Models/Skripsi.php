<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skripsi extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $table = 'skripsis';

    protected $fillable = [
        'judulskripsi',
        'nama_mahasiswa',
        'dosenpembimbing',
        'tahunterbit',
        'abstract' // Abstrak atau deskripsi singkat

    ];
}
