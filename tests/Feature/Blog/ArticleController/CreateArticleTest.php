<?php

/* @covers \App\Blog\Controllers\ArticleController::store */

use Domain\Blog\Actions\CreateArticle;
use Domain\Blog\Data\ArticleData;
use Domain\Blog\Models\Article;
use Domain\Blog\Models\Topic;
use Domain\User\Models\Author;
use Domain\User\Models\User;

it('is successful', function (): void {

    $author = Author::factory()
        ->for(User::factory()->state(['name' => 'Gael Faye']))
        ->create();

    $article = Article::factory()->hasTopics()->create();

    $this->mock(CreateArticle::class)
        ->shouldReceive('execute')
        ->withArgs(
            function (Author $author, ArticleData $data) {
                return $author->id === $author->id
                    && $data->title === 'title'
                    && $data->summary === 'summary'
                    && $data->url === 'http://example.com';
            }
        )
        ->once()
        ->andReturn($article);

    $this->be($author->user)
        ->postJson('api/articles', [
            'title' => 'title',
            'summary' => 'summary',
            'url' => 'http://example.com',
            'topics' => [],
        ])
        ->assertCreated()
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
            'topics' => $article->topics
                ->map(fn (Topic $topic) => ['id' => $topic->id, 'label' => $topic->label])
                ->toArray(),
        ]);
});
