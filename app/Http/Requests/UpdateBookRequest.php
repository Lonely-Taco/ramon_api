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
            'id'               => [
            ],
            'title'            => [
            ],
            'authors'          => [
            ],
            'average_rating'   => [
            ],
            'ratings_count'    => [
            ],
            'publication_date' => [
            ],
        ];
    }
}
