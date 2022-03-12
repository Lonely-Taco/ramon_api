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
            'runtime' => $row[5],
        ]);

        $tags = $this->makeTags($row[4]);

        $movie->save();

        if ($tags == null) {
            return;
        }

        $movie->tags()->attach($tags);
    }

    public function makeTags(?string $tags): Collection
    {
        $tagCollection = new Collection();

        if ($tags == null) {
            return $tagCollection;
        }

        $tagsArray = explode(';', $tags);

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
