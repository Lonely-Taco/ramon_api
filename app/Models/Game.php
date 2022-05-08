<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @OA\Schema(
 * @OA\Property(property="name", type="string", description="title of the film"),
 * @OA\Property(property="release_date", type="string", format="date",description="year of release"),
 * @OA\Property(property="categories", type="string", description="categories for a game e.g 'Multi-player'"),
 * @OA\Property(property="genres", type="string", description="generes for a game"),
 * @OA\Property(property="positive_ratings", type="integer", description="positive ratings"),
 * @OA\Property(property="negative_ratings", type="integer", description="negative ratings"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * )
 * Class BaseModel
 *
 * @package App\Models
 */


/**
 * App\Models\Game
 *
 * @property int $id
 * @property string $name
 * @property string $release_date
 * @property string $categories
 * @property string $genres
 * @property int $positive_ratings
 * @property int $negative_ratings
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCategories($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereGenres($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereNegativeRatings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game wherePositiveRatings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Game extends Model
{
    use HasFactory;
    use Taggable;

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
