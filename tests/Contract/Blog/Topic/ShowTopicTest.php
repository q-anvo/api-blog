<?php

/* @covers \App\Blog\Controllers\TopicController::show */

use Domain\Blog\Models\Topic;
use Domain\User\Models\User;

it('respects success contract', function (): void {
    $topic = Topic::factory()->create();

    $this
        ->be(User::factory()->create())
        ->getJson("api/topics/{$topic->id}")
        ->assertValidRequest()
        ->assertValidResponse(200);
});
