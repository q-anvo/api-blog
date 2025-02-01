<?php

/* @covers \App\Blog\Controllers\ArticleController::show */

use Domain\Blog\Models\Article;
use Domain\User\Models\User;

it('is successful', function (): void {

    $article = Article::factory()->create();

    $user = User::factory()->create();

    $this
        ->be($user)
        ->get("api/articles/{$article->id}")
        ->assertOk()
        ->assertJsonFragment([
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
            'topics' => [],
        ]);
});
