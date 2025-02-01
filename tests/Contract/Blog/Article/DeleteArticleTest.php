<?php

/* @covers \App\Blog\Controllers\ArticleController::destroy */

use Domain\Blog\Models\Article;

it('respects success contract', function (): void {
    $article = Article::factory()->create();

    $this
        ->be($article->author->user)
        ->deleteJson("api/articles/{$article->id}")
        ->assertValidRequest()
        ->assertValidResponse(204);
});
