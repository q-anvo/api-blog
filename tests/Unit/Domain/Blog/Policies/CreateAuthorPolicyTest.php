<?php

/* @covers \Domain\Blog\Policies\AuthorPolicy */

use Domain\User\Models\Author;
use Domain\User\Models\User;

it('denies a user to become an author', function (): void {
    $user = User::factory()->createOne();

    expect($user)->can('create', Author::class)->toBeTrue();
});

it('allows user to become an author', function (): void {
    $author = Author::factory()->createOne();

    expect($author->user)->can('create', Author::class)->toBeFalse();
});
