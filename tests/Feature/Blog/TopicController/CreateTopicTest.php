<?php

/* @covers \App\Blog\Controllers\TopicController::store */

use Domain\Blog\Models\Topic;
use Domain\User\Models\User;

test('auth user can create a topic', function () {
    $user = User::factory()->create();

    $this->be($user)
        ->post(route('topics.store'), [
            'label' => 'Test Topic',
        ])
        ->assertNoContent();

    $this->assertDatabaseHas(Topic::class, [
        'label' => 'Test Topic',
    ]);
});
