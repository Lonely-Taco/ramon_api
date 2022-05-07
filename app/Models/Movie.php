<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * @OA\Property(property="title", type="string", description="title of the film"),
 * @OA\Property(property="year", type="integer", description="year of release"),
 * @OA\Property(property="iMDb", type="integer", description="IMDB score"),
 * @OA\Property(property="genres", type="string", description="generes for the movie"),
 * @OA\Property(property="runtime", type="integer", description="movie duration"),
 * @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 * @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 * )
 * Class BaseModel
 *
 * @package App\Models
 */

/**
 * App\Models\Movie
 *
 * @property int $id
 * @property string $title
 * @property int $year
 * @property float|null $iMDb
 * @property int|null $runtime
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Movie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereIMDb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereRuntime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereYear($value)
 * @mixin \Eloquent
 */
class Movie extends Model
{
    use HasFactory;
    use Taggable;

    protected $fillable = [
        'title',
        'year',
        'iMDb',
        'genres',
        'runtime',
    ];
}
