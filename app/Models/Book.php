<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="title", type="string", description="title of the film"),
 * @OA\Property(property="authors", type="string", description="book author/s"),
 * @OA\Property(property="average_rating", type="integer", description="Book rating"),
 * @OA\Property(property="ratings_count", type="string", description="number of ratings"),
 * @OA\Property(property="publication_date", type="integer", description="publication year")),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * )
 * Class BaseModel
 *
 * @package App\Models
 */


/**
 * App\Models\Book
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $authors
 * @property float|null $average_rating
 * @property int|null $ratings_count
 * @property string|null $publication_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAuthors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereAverageRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book wherePublicationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereRatingsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Book whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Book extends Model
{
    use HasFactory;
    use Taggable;

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
}
