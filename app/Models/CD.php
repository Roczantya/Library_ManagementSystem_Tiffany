<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CD extends Model
{
     /**
     * fillable
     *
     * @var array
     */

     use HasFactory;

     protected $table = 'CD';

     protected $fillable =[
         'title',
         'artist',
         'publisher',
         'releease_year',
         'genre',
       
     ];
}
