<?php

namespace App\Http\Controllers;

use App\Charts\BookChart;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class ConsumeBooksController extends Controller
{
    public function index()
    {
        $request = Request::create('/api/books', 'GET');

        $books = json_decode(Route::dispatch($request)->getContent());

        return view('books.books', ['books' => $books]);
    }

    public function show(int $id)
    {
        $request = Request::create('/api/book/' . $id, 'GET');

        $book = json_decode(Route::dispatch($request)->getContent());

        return view('books.books', ['book' => $book]);
    }

    public function chart(Request $request)
    {
        /** @var Collection<Tag> $tags */
        $tags = Tag::whereHas('books')->orderBy('name')->get();

        return view('charts.book-chart', ['tags' => $tags]);
    }
}
