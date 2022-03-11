<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class BookImport implements ToModel
{
    public function model(array $row)
    {
        /** @var Book $book */
        $book = Book::query()->create([
            'title'            => $row[0],
            'authors'          => $row[1],
            'categories'       => explode(',', $row[2])[0],
            'average_rating'   => $row[3],
            'ratings_count'    => $row[4],
            'publication_date' => date('y-m-d', strtotime($row[5])),
        ]);

        $tags = $this->makeTags($row[2]);

        $book->save();

        if ($tags == null) {
            return;
        }
        $book->tags()->attach($tags);
    }

    public function makeTags(?string $tag): Collection
    {
        $tagCollection = new Collection();
        if ($tag == null) {
            return $tagCollection;
        }

        $newTag = Tag::firstOrNew([
            'name' => $tag,
        ]);
        $newTag->save();

        $tagCollection->add($newTag);


        return $tagCollection;
    }
}
