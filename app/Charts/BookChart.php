<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Tag;
use Chartisan\PHP\Chartisan;
use Chartisan\PHP\DatasetData;
use ConsoleTVs\Charts\BaseChart;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

class BookChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        /** @var Collection<Tag> $tags */
        $request = Request::create('/api/tags/getBookTags', 'GET');

        $tags = json_decode(Route::dispatch($request)->getContent());


        $chart = Chartisan::build();

        /** @var array $tagArray */
        $tagArray = $tags->data;

        for ($i = 0; $i < count($tagArray); $i++) {
            $serverData                  = $chart->toObject();
            $serverData->chart->labels[] = $tagArray[$i]->name;
            
            $models = DB::table('book_tag')->where('tag_id', '=', $tagArray[$i]->id)->get();

            if ($i === 0) {
                // First round, create the initial data
                $serverData->datasets[0] = new DatasetData('Books per tag', [$models->count()], null);
            } else {
                // Append to existing
                $serverData->datasets[0]->values[] = $models->count();
            }
        }


//        $tags->each(function (Tag $tag, int $i) use ($chart) {
//            $serverData                  = $chart->toObject();
//            $serverData->chart->labels[] = $tag->name;
//
//            if ($i === 0) {
//                // First round, create the initial data
//                $serverData->datasets[0] = new DatasetData('tags', [$tag->books->count()], null);
//            } else {
//                // Append to existing
//                $serverData->datasets[0]->values[] = $tag->books->count();
//            }
//        });

        return $chart;
    }
}
