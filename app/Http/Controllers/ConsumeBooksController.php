<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
