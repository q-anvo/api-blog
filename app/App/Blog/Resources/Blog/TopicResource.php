<?php

namespace App\Blog\Resources\Blog;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Domain\Blog\Models\Topic
 */
class TopicResource extends JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'label' => $this->label,
            'articles_count' => $this->articles_count,
        ];
    }
}
