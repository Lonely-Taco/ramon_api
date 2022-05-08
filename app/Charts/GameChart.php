<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Game;
use App\Models\Tag;
use Chartisan\PHP\Chartisan;
use Chartisan\PHP\DatasetData;
use ConsoleTVs\Charts\BaseChart;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class GameChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $request = Request::create('/api/tags/getGameTags', 'GET');

        $tags = json_decode(Route::dispatch($request)->getContent());

        $chart = Chartisan::build();

        $tagArray = $tags->data;

        for ($i = 0; $i < count($tagArray); $i++) {
            $serverData                  = $chart->toObject();
            $serverData->chart->labels[] = $tagArray[$i]->name;

            $movies = DB::table('movie_tag')->where('tag_id', '=', $tagArray[$i]->id)->get();
            $books  = DB::table('book_tag')->where('tag_id', '=', $tagArray[$i]->id)->get();
            $games  = DB::table('game_tag')->where('tag_id', '=', $tagArray[$i]->id)->get();

            if ($i === 0) {
                // First round, create the initial data
                $serverData->datasets[] = new DatasetData('Movies per tag', [$movies->count()], null);
                $serverData->datasets[] = new DatasetData('Books per tag', [$books->count()], null);
                $serverData->datasets[] = new DatasetData('Games per tag', [$games->count()], null);
            } else {
                // Append to existing
                $serverData->datasets[0]->values[] = $movies->count();
                $serverData->datasets[1]->values[] = $books->count();
                $serverData->datasets[2]->values[] = $games->count();
            }
        }

        return $chart;

    }
}
