<?php

declare(strict_types=1);

namespace App\Charts;

use App\Models\Tag;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;

class GameChart extends BaseChart
{
    public function handler(Request $request): Chartisan
    {
        $tags = Tag::all();

        $labelNames  = array();
        $labelCounts = array();

        foreach ($tags as $num => $tag) {
            $labelNames[$num] = $tag->name;
            if ($tag->games()->count() != 0) {
                $labelCounts[$num] = $tag->games()->count();
            }
            $labelNames[$num] = $tag->name;
            if ($tag->games()->count() != 0) {
                $labelCounts[$num] = $tag->games()->count();
            }
            $labelNames[$num] = $tag->name;
            if ($tag->books()->count() != 0) {
                $labelCounts[$num] = $tag->books()->count();
            }

        }
        
        return Chartisan::build()
            ->labels($labelNames)
            ->dataset('Sample', $labelCounts)
            ->dataset('Sample', [1, 2, 3])
            ->dataset('Sample 2', [3, 2, 1]);
    }
}
