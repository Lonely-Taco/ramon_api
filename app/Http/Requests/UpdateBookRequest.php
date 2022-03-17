<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateBookRequest extends FormRequest
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
            'title'             => [
                'required',
                'string',
            ],
            'authors'     => [
                'string',
                'required',
            ],
            'average_rating'       => [
                'float',

            ],
            'ratings_count'           => [
                'integer',
            ],
            'publication_date' => [
                'required',
                'date',

            ],
        ];
    }
}
