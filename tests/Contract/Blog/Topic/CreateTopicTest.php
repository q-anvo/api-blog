<?php

/* @covers \App\Blog\Controllers\TopicController::store */
use Domain\User\Models\User;

it('respects success contract', function (): void {

    $this
        ->be(User::factory()->create())
        ->postJson('api/topics', [
            'label' => 'Test Topic',
        ])
        ->assertValidRequest()
        ->assertValidResponse(204);
});
