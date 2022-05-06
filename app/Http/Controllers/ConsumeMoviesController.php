<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class ConsumeMoviesController extends Controller
{
    public function index()
    {
        $request = Request::create('/api/movies', 'GET');

        $movies = Route::dispatch($request)->getContent();

        return view('movies.movies', compact($movies));
    }

    public function show(int $id)
    {
        $request = Request::create('/api/movie/' . $id, 'GET');

        $movie = json_decode(Route::dispatch($request)->getContent());

//        dump($movie);
//        exit();
        return view('movies.movies', ['movie' => $movie]);

    }

    public function chart(DatabaseManager $databaseManager)
    {
        /** @var Collection<Tag> $tags */
        $tags = Tag::whereHas('movies')->get();

        return view('charts.movie-chart', ['tags' => $tags]);
    }
}
