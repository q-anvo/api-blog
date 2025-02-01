<?php

/* @covers \App\Blog\Controllers\AuthorController::store */

use Domain\User\Models\User;

it('respects success contract', function (): void {

    $user = User::factory()->create();

    $this
        ->be($user)
        ->postJson('api/authors')
        ->assertValidRequest()
        ->assertValidResponse(204);
});
