<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Tag;
use Chartisan\PHP\Chartisan;
use Chartisan\PHP\DatasetData;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MovieChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        /** @var Collection<Tag> $tags */
        $tags = Tag::whereHas('movies')->get();

        $chart = Chartisan::build();

        $tags->each(function (Tag $tag, int $i) use ($chart) {
            $serverData                  = $chart->toObject();
            $serverData->chart->labels[] = $tag->name;

            if ($i === 0) {
                // First round, create the initial data
                $serverData->datasets[0] = new DatasetData('tags', [$tag->movies->count()], null);
            } else {
                // Append to existing
                $serverData->datasets[0]->values[] = $tag->movies->count();
            }
        });

        return $chart;
    }
}
