<?php

namespace App\Imports;

use App\Models\Movie;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class MovieImport implements ToModel
{
    public function model(array $row)
    {
        $movie = Movie::create([
            'title'   => $row[1],
            'year'    => $row[2],
            'iMDb'    => $row[3],
            'genres'  => explode(',', $row[4])[0],
            'runtime' => $row[5],
        ]);

        $tags = $this->makeTags($row[4]);

        $movie->save();

        $movie->tags()->attach($tags);
    }

    public function makeTags(string $tags): Collection
    {
        $tagCollection = new Collection();
        $tagsArray     = explode(';', $tags);

        foreach ($tagsArray as $tag) {
            $newTag = Tag::firstOrNew([
                'name' => $tag,
            ]);

            $newTag->save();

            $tagCollection->add($newTag);
        }

        return $tagCollection;
    }
}
