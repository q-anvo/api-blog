<?php

/* @covers \App\Blog\Controllers\TopicController::index */

use Domain\Blog\Models\Topic;
use Domain\User\Models\User;

it('respects success contract', function (): void {

    Topic::factory(5)->create();

    $this
        ->be(User::factory()->create())
        ->getJson('api/topics')
        ->assertValidRequest()
        ->assertValidResponse(200);
});
