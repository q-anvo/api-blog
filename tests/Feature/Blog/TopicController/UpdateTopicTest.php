<?php

/* @covers \App\Blog\Controllers\TopicController::update */

use Domain\Blog\Models\Topic;
use Domain\User\Models\User;

test('auth user can update a topic', function () {
    $user = User::factory()->create();

    $topic = Topic::factory()
        ->hasArticles(3)
        ->create([
            'label' => 'Test Topic',
        ]);

    $this->be($user)
        ->put("api/topics/{$topic->id}", ['label' => 'Updated Topic'])
        ->assertNoContent();

    $this->assertDatabaseHas(Topic::class, [
        'label' => 'Updated Topic',
    ]);
});
