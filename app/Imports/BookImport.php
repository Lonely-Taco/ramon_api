<?php

namespace App\Imports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\ToModel;

class BookImport implements ToModel
{
    public function model(array $row)
    {
        /** @var Book $book */
        Book::query()->create([
            'title'            => $row[1],
            'authors'          => $row[2],
            'average_rating'   => $row[3],
            'ratings_count'    => $row[4],
            'publication_date' => date('y-m-d', strtotime($row[5])),
        ]);
    }
}
