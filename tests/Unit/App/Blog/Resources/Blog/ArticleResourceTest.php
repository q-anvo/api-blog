<?php

/* @covers \App\Blog\Resources\Blog\ArticleResource */

use App\Blog\Resources\Blog\ArticleResource;
use Domain\Blog\Models\Article;

it('formats the article', function (): void {
    $article = Article::factory()->createOne();

    $article->setAttribute('topics_count', 5);

    $resource = (ArticleResource::make($article))->toArray(null);

    expect($resource)
        ->toBe([
            'id' => $article->id,
            'title' => $article->title,
            'url' => $article->url,
            'author' => [
                'user_id' => $article->author->user_id,
                'user_name' => $article->author->user->name,
            ],
            'created_at' => $article->created_at->toDateTimeString(),
            'updated_at' => $article->updated_at->toDateTimeString(),
            'topics_count' => 5,
        ]);
});
