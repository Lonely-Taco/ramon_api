<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        if ($request->accepts('json')) {
            return response()->json(Game::all(), 200);
        } else {
            return response()->xml(Game::all(), 200);
        }

    }

    public function show(Request $request, $id)
    {
        $acceptedType = $request->getAcceptableContentTypes();

        if ($acceptedType[0] === 'application/json') {
            return response()->json(Game::findOrFail($id), 200);
        }

        if ($acceptedType[0] === 'application/xml') {
            return response()->xml(Game::findOrFail($id), 200);
        }


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
