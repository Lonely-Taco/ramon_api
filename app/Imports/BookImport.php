<?php

namespace App\Imports;

use App\Models\Book;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class BookImport implements ToModel
{
    /**
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|void|null
     */
    public function model(array $row)
    {
        /** @var Book $book */
        $book = Book::query()->create([
            'title'            => $row[0],
            'authors'          => $row[1],
            'average_rating'   => $row[3],
            'ratings_count'    => $row[4],
            'publication_date' => Carbon::parse($row[5])->year,
        ]);

        $tags = $this->makeTags($row[2]);

        $book->save();

        if ($tags == null) {
            return;
        }

        $book->tags()->attach($tags);
    }

    /**
     * @param string|null $tag
     * @return Collection
     */
    public function makeTags(?string $tags): Collection
    {
        $tagCollection = new Collection();

        if ($tags == null) {
            return $tagCollection;
        }

        $tagsArray = explode(',', $tags);

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
