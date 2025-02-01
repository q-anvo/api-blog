<?php

/* @covers \App\Blog\Controllers\ArticleController::update */

use Domain\Blog\Models\Article;
use Domain\Blog\Models\Topic;
use Domain\User\Models\User;

it('respects success contract', function (): void {
    $article = Article::factory()->create();
    $topic = Topic::factory()->create();

    $this
        ->be(User::factory()->create())
        ->putJson("api/articles/{$article->id}", [
            'title' => 'new title',
            'summary' => 'new content',
            'url' => 'http://new.url.com',
            'topics' => [$topic->id],
        ])
        ->assertValidRequest()
        ->assertValidResponse(204);
});
