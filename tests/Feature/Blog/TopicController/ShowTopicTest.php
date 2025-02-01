<?php

/* @covers \App\Blog\Controllers\TopicController::show */

use Domain\Blog\Models\Topic;
use Domain\User\Models\User;

test('auth user can see a topic', function () {
    $user = User::factory()->create();

    $topic = Topic::factory()
        ->hasArticles(3)
        ->create([
            'label' => 'Test Topic',
        ]);

    $this->be($user)
        ->get(route('topics.show', $topic))
        ->assertSuccessful()
        ->assertJsonPath('data', [
            'id' => $topic->id,
            'label' => 'Test Topic',
            'articles_count' => 3,
        ]);
});
