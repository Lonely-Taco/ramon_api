<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class ConsumeGamesController extends Controller
{
    public function index(): View
    {
        $request = Request::create('/api/games', 'GET');

        $games = json_decode(Route::dispatch($request)->getContent());

        return view('games.games', ['games' => $games]);
    }

    public function show(int $id): View
    {
        $request = Request::create('/api/game/' . $id, 'GET');

        $game = json_decode(Route::dispatch($request)->getContent());

        return view('games.game', ['game' => $game]);

    }

    public function destroy(int $id)
    {
        $request = Request::create('/api/game/' . $id, 'DELETE');

        $game = json_decode(Route::dispatch($request)->getContent());

        dump($game);
    }
}
