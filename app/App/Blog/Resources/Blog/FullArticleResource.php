<?php

namespace App\Blog\Resources\Blog;

use Domain\Blog\Models\Topic;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Domain\Blog\Models\Article
 */
class FullArticleResource extends JsonResource
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
            'summary' => $this->summary,
            'url' => $this->url,
            'author' => [
                'user_id' => $this->author?->user_id,
                'user_name' => $this->author?->user->name,
            ],
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'topics' => $this->topics
                ->map(fn (Topic $topic) => ['id' => $topic->id, 'label' => $topic->label])
                ->toArray(),
        ];
    }
}
