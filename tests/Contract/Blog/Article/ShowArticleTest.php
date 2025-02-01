<?php

/* @covers \App\Blog\Controllers\ArticleController::show */

use Domain\Blog\Models\Article;
use Domain\User\Models\User;

it('respects success contract', function (): void {

    $article = Article::factory()->create();

    $this
        ->be(User::factory()->create())
        ->getJson("api/articles/{$article->id}")
        ->assertValidRequest()
        ->assertValidResponse(200);
});
