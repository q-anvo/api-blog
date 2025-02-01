<?php

/**
 * @covers \Domain\Blog\Policies\ArticlePolicy
 */

use Domain\Blog\Models\Article;
use Domain\User\Models\Author;
use Domain\User\Models\User;

it('denies a user to create an article', function (): void {
    $user = User::factory()->createOne();

    expect($user)->can('create', Article::class)->toBeFalse();
});

it('allows author to create an article', function (): void {
    $author = Author::factory()->createOne();

    expect($author->user)->can('create', Article::class)->toBeTrue();
});
