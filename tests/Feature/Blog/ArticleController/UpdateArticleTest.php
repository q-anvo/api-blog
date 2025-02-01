<?php

/* @covers \App\Blog\Controllers\ArticleController::update */

use Domain\Blog\Actions\UpdateArticle;
use Domain\Blog\Data\ArticleData;
use Domain\Blog\Models\Article;

it('is successful', function (): void {

    $article = Article::factory()->create();

    $this->mock(UpdateArticle::class)
        ->shouldReceive('execute')
        ->withArgs(
            function (Article $article, ArticleData $data) {
                return $article->id === $article->id
                    && $data->title === 'title'
                    && $data->summary === 'summary'
                    && $data->url === 'http://example.com';
            }
        )
        ->once();

    $this
        ->be($article->author->user)
        ->put(route('articles.update', $article), [
            'title' => 'title',
            'summary' => 'summary',
            'url' => 'http://example.com',
        ])
        ->assertNoContent();

});
