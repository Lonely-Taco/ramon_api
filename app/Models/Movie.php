<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Movie
 *
 * @property int $id
 * @property string $title
 * @property int $year
 * @property float|null $iMDb
 * @property string|null $genres
 * @property int|null $runtime
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Movie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie query()
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Movie whereGenres($value)
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

    protected $fillable = [
        'title',
        'year',
        'iMDb',
        'genres',
        'runtime',
    ];

    //-----------------------------------------------------------------------------
    // Relationships
    //-----------------------------------------------------------------------------

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
