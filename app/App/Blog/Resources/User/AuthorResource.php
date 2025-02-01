<?php

namespace App\Blog\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \Domain\User\Models\Author
 */
class AuthorResource extends JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'articles_count' => $this->articles_count,
            'username' => $this->user->name,
        ];
    }
}
