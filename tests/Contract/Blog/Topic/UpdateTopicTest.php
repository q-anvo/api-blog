<?php

/* @covers \App\Blog\Controllers\TopicController::update */

use Domain\Blog\Models\Topic;
use Domain\User\Models\User;

it('respects success contract', function (): void {
    $topic = Topic::factory()->create();

    $this
        ->be(User::factory()->create())
        ->putJson("api/topics/{$topic->id}", [
            'label' => 'new label',
        ])
        ->assertValidRequest()
        ->assertValidResponse(204);
});
