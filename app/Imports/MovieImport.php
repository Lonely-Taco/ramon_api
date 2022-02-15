<?php

namespace App\Imports;

use App\Models\Movie;
use Maatwebsite\Excel\Concerns\ToModel;

class MovieImport implements ToModel
{
    public function model(array $row)
    {
        Movie::query()->create([
            'title'   => $row[1],
            'year'    => $row[2],
            'iMDb'    => $row[3],
            'genres'  => $row[4],
            'runtime' => $row[5],
        ]);
    }
}
