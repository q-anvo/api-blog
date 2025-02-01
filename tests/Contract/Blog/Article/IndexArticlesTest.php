<?php

/* @covers \App\Blog\Controllers\ArticleController::index */

use Domain\Blog\Models\Article;
use Domain\User\Models\User;

it('respects success contract', function (): void {
    Article::factory()->create();

    $this
        ->be(User::factory()->create())
        ->getJson('api/articles')
        ->assertValidRequest()
        ->assertValidResponse(200);
});
