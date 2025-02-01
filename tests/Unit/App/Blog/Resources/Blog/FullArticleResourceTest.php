<?php

/* @covers \App\Blog\Resources\Blog\FullArticleResource */

use App\Blog\Resources\Blog\FullArticleResource;
use Domain\Blog\Models\Article;
use Domain\Blog\Models\Topic;

it('formats the article', function (): void {

    $topic = Topic::factory()->createOne();
    $article = Article::factory()->hasAttached($topic)->createOne();

    $article->setAttribute('topics_count', 5);

    $resource = (FullArticleResource::make($article))->toArray(null);

    expect($resource)
        ->toBe([
            'id' => $article->id,
            'title' => $article->title,
            'summary' => $article->summary,
            'url' => $article->url,
            'author' => [
                'user_id' => $article->author->user_id,
                'user_name' => $article->author->user->name,
            ],
            'created_at' => $article->created_at->toDateTimeString(),
            'updated_at' => $article->updated_at->toDateTimeString(),
            'topics' => [
                ['id' => $topic->id, 'label' => $topic->label],
            ],
        ]);
});
