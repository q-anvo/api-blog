<?php

namespace App\Blog\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'summary' => ['required', 'string'],
            'url' => ['required', 'string', 'url'],
            'topics' => ['array'],
            'topics.*' => ['required', 'integer', 'exists:topics,id'],
        ];
    }
}
