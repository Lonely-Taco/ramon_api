<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class BookController extends Controller
{
    public function viewAll(): Collection
    {
        return Book::all();
    }

    public function view(int $id): Book
    {
        return Book::query()->findOrFail($id)->first();
    }

    public function update(int $id, array $values): Book
    {
        $book = Book::query()->findOrFail($id)->first();

        $book->update($values);

        return $book;
    }

    public function delete(int $id): string
    {

        $book = Book::query()->findOrFail($id)->first();

        if (!$book) {

            return "book not found";
        }

        $book->delete();

        return "book deleted";
    }
}
