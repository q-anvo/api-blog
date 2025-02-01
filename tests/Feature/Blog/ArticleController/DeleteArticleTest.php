<?php

/* @covers \App\Blog\Controllers\ArticleController::destroy */

use Domain\Blog\Models\Article;

it('is successful', function (): void {

    $article = Article::factory()->create();

    $this
        ->be($article->author->user)
        ->delete("api/articles/{$article->id}")
        ->assertNoContent();

    $this->assertDatabaseMissing(Article::class, ['id' => $article->id]);
});
