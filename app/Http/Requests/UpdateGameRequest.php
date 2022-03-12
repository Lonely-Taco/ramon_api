<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, string[]>
     */
    public function rules(Request $request): array
    {
        return [
            'name'             => [
                'required',
                'string',
            ],
            'release_date'     => [
                'required',
            ],
            'categories'       => [
                'required',
                'string',

            ],
            'genres'           => [
                'required',
                'string',
            ],
            'positive_ratings' => [
                'required',
                'integer',

            ],
            'negative_ratings' => [
                'required',
                'integer',
            ],

        ];
    }
}
//"release_date": "2000-11-01",
//    "categories": "Multi-player;Online Multi-Player;Local Multi-Player;Valve Anti-Cheat enabled",
//    "genres": "Action",
//    "positive_ratings": 124534,
//    "negative_ratings": 3339,
