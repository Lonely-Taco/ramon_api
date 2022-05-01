<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Game;
use App\Models\Tag;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GameChart extends BaseChart
{

        protected array $tag;

    public function __construct(
        protected Collection $dataset0,
        protected Collection $dataset1,
        protected Collection $dataset2,
    ) {

        $games = Game::all();
        $tags = Tag::all();

        foreach ($games as $game){
            $this->tag[$game->name] = $game->tags_count;
        }

        dd($this->tag);
        $this->dataset0 = $games->tags->pluck('id');
        $this->dataset1 = $games->pluck('name');
    }

    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {


        return Chartisan::build()
            ->labels($this->dataset1->toArray())
            ->dataset('Sample', $this->dataset0->toArray());
    }
}
