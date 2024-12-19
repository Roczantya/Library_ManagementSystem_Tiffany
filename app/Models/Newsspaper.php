<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsspaper extends Model
{
    use HasFactory;

    protected $table = 'newsspapers';

    protected $fillable = [
        'judul_surat_kabar',
        'publication_date',
        'publisher',
    ];
}
