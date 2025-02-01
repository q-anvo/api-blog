<?php

/* @covers \App\Blog\Controllers\AuthorController::store */

use Domain\User\Models\User;

it('is successful', function (): void {

    $user = User::factory()->create();

    $this
        ->be($user)
        ->postJson('api/authors')
        ->assertNoContent();
});
