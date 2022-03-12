<?php

namespace App\Imports;

use App\Models\Game;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class GameImport implements ToModel
{
    public function model(array $row)
    {
        /** @var Game $game */
        $game = Game::make([
            'name'             => $row[1],
            'release_date'     => $row[2],
            'categories'       => $row[3],
            'genres'           => $row[4],
            'positive_ratings' => $row[6],
            'negative_ratings' => $row[7],
        ]);

        $tags = $this->makeTags($row[5]);

        $game->save();

        $game->tags()->attach($tags);
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
