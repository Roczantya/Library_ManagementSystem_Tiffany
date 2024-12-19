<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $table = 'journals';

    protected $fillable =[
        'judul',
        'Author',
        'penerbit',
        'tahun_terbit',
        'isbn',
      
    ];
}