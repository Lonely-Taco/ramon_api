<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'release_date',
        'categories',
        'genres',
        'steamspy_tags',
        'positive_ratings',
        'negative_ratings',
    ];
}
