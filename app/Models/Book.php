<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'authors',
        'categories',
        'average_rating',
        'ratings_count',
        'publication_date',

    ];

    protected $casts = [
        'average_rating' => 'float',
    ];

    public $incrementing = false;
}
