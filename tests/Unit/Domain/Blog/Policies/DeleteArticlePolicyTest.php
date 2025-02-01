<?php

/* @covers \Domain\Blog\Policies\ArticlePolicy */

use Domain\Blog\Models\Article;
use Domain\User\Models\Author;
use Domain\User\Models\User;

it('denies a user to delete any article', function (): void {
    $user = User::factory()->createOne();
    $article = Article::factory()->createOne();

    expect($user)->can('delete', $article)->toBeFalse();
});

it('allows author to delete its article', function (): void {
    $author = Author::factory()->createOne();
    $article = Article::factory()->for($author)->createOne();

    expect($author->user)->can('delete', $article)->toBeTrue();
});
