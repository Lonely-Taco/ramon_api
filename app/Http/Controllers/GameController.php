<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Database\Eloquent\Collection;

class GameController extends Controller
{
    public function index(): array|Collection
    {
        return Game::all();
    }

    public function show($id): Game
    {
        return Game::find($id);
    }

    public function create(UpdateGameRequest $request): Game
    {
        return Game::create($request->validated());
    }

    public function edit($id, UpdateGameRequest $request): Game
    {
        $game = Game::findOrFail($id);

        $game->update($request->validated());

        $game->save();

        return $game;

    }

    public function destroy($id)
    {
        $game = Game::findOrFail($id);

        $game->delete();

        return response('', 204);
    }
}
