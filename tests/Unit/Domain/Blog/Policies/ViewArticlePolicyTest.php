<?php

/* @covers \Domain\Blog\Policies\ArticlePolicy */

use Domain\Blog\Models\Article;
use Domain\User\Models\Author;
use Domain\User\Models\User;

it('allows user to see articles', function (): void {
    $user = User::factory()->createOne();
    $article = Article::factory()->createOne();

    expect($user)->can('view', $article)->toBeTrue();
});

it('allows author to see its articles', function (): void {
    $author = Author::factory()->createOne();
    $article = Article::factory()->for($author)->createOne();

    expect($author->user)->can('view', $article)->toBeTrue();
});
