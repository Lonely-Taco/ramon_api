<?php

namespace App\Imports;

use App\Models\Game;
use Maatwebsite\Excel\Concerns\ToModel;

class GameImport implements ToModel
{
    public function model(array $row)
    {
        Game::query()->create([
            'name'             => $row[1],
            'release_date'     => $row[2],
            'categories'       => $row[3],
            'genres'           => $row[4],
            'steamspy_tags'    => $row[5],
            'positive_ratings' => $row[6],
            'negative_ratings' => $row[7],
        ]);
    }
}
