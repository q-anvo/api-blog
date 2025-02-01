<?php

/* @covers \Domain\Blog\Actions\CreateArticle */

use Domain\Blog\Actions\CreateArticle;
use Domain\Blog\Data\ArticleData;
use Domain\Blog\Models\Article;
use Domain\User\Models\Author;

test('author can create an article', function () {

    $author = Author::factory()->create();

    $data = ArticleData::from([
        'title' => 'title',
        'summary' => 'summary',
        'url' => 'url',
    ]);

    $article = app(CreateArticle::class)->execute($author, $data);

    $this->assertDatabaseHas(Article::class, [
        'id' => $article->id,
        'author_id' => $author->id,
        'title' => 'title',
        'summary' => 'summary',
        'url' => 'url',
    ]);

    expect($article)
        ->toBeInstanceOf(Article::class)
        ->author_id->toBe($author->id)
        ->title->toBe('title')
        ->summary->toBe('summary')
        ->url->toBe('url');
});
