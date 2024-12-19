<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
 /**
     * fillable
     *
     * @var array
     */

     protected $table = 'books';

    protected $fillable = [

    'judul',
    'penerbit',
    'penulis',
    'tahun_terbit',
    'ISBN',
    'isEbook',
    'ebookLink',
    'isBorrowed',
];
}
