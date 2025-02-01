<?php

namespace App\Blog\Resources\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Domain\Blog\Models\Article
 */
class ArticleResource extends JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'author' => [
                'user_id' => $this->author?->user_id,
                'user_name' => $this->author?->user->name,
            ],
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'topics_count' => $this->topics_count,
        ];
    }
}
