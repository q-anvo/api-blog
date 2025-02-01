<?php

/* @covers \App\Blog\Resources\User\AuthorResource */

use App\Blog\Resources\User\AuthorResource;
use Domain\User\Models\Author;

it('formats the author', function (): void {
    $author = Author::factory()->createOne();

    $resource = (AuthorResource::make($author))->toArray(null);

    expect($resource)->toBe([
        'id' => $author->id,
        'user_id' => $author->user_id,
        'articles_count' => $author->articles_count,
        'username' => $author->user->name,
    ]);
});
