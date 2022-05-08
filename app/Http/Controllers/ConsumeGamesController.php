<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
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

        return redirect('games.game', ['game' => $game])->with(['success' => $game->name . 'Deleted']);
    }

    public function chart(DatabaseManager $databaseManager)
    {

        /** @var Collection<Tag> $tags */
        $tags = Tag::whereHas('games')->orderBy('name')->get();

        return view('charts.game-chart', ['tags' => $tags]);
    }


}
