<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;

class BookController extends Controller
{
    public function index(): array|Collection
    {
        return Book::all();
    }

    public function show($id): Book
    {
        return Book::find($id);
    }

    public function create(UpdateBookRequest $request): Book
    {
        return Book::create($request->validated());
    }

    public function edit($id, UpdateBookRequest $request): Book
    {
        $game = Book::findOrFail($id);

        $game->update($request->validated());

        $game->save();

        return $game;
    }

    public function destroy($id)
    {
        $game = Book::findOrFail($id);

        $game->delete();

        return response('', 204);
    }
}
