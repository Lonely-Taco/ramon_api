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
