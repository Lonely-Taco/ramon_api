<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'authors',
        'average_rating',
        'ratings_count',
        'publication_date',

    ];

    protected $casts = [

    ];

//bookID, title, authors, average_rating, ratings_count, publication_date,
}
