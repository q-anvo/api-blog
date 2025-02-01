<?php

/* @covers \Domain\Blog\Actions\UpdateArticle */

use Domain\Blog\Actions\UpdateArticle;
use Domain\Blog\Data\ArticleData;
use Domain\Blog\Models\Article;

test('author can update an article', function () {
    $article = Article::factory()->create();

    $data = ArticleData::from([
        'title' => 'title',
        'summary' => 'summary',
        'url' => 'url',
    ]);

    app(UpdateArticle::class)->execute($article, $data);

    $this->assertDatabaseHas(Article::class, [
        'id' => $article->id,
        'title' => 'title',
        'summary' => 'summary',
        'url' => 'url',
    ]);
});
