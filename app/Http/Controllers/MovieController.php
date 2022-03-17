<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

class MovieController extends Controller
{
    public function index(): array|Collection
    {
        return Movie::all();
    }

    public function show($id): Movie
    {
        return Movie::find($id);
    }

    public function create(UpdateMovieRequest $request): Movie
    {
        return Movie::create($request->validated());
    }

    public function edit($id, UpdateMovieRequest $request): Movie
    {
        $game = Movie::findOrFail($id);

        $game->update($request->validated());

        $game->save();

        return $game;

    }

    public function destroy($id)
    {
        $game = Movie::findOrFail($id);

        $game->delete();

        return response('', 204);
    }
}
