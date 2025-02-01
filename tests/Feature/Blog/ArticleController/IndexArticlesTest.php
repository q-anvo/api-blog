<?php

/* @covers \App\Blog\Controllers\ArticleController::index */

use Domain\Blog\Models\Article;
use Domain\User\Models\User;

it('is successful', function (): void {
    $article = Article::factory()
        ->hasTopics(5)
        ->create();

    $user = User::factory()->create();

    $this
        ->be($user)
        ->get(route('articles.index'))
        ->assertOk()
        ->assertJsonPath('data.0', [
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

it('sorts articles by title', function (): void {
    $articles = Article::factory(10)->create();

    $user = User::factory()->create();

    $this
        ->be($user)
        ->get(route('articles.index'))
        ->assertOk()
        ->assertJsonCount(10, 'data')
        ->assertJsonPath(
            'data.*.title',
            $articles->pluck('title')->sort()->values()->toArray()
        );
});
