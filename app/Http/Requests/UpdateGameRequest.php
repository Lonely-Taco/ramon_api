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
            'id'               => [
            ],
            'name'             => [
            ],
            'release_date'     => [
            ],
            'categories'       => [
            ],
            'genres'           => [
            ],
            'positive_ratings' => [
            ],
            'negative_ratings' => [
            ],
        ];
    }
}
