<?php

/* @covers \App\Blog\Controllers\TopicController::index */

use Domain\Blog\Models\Topic;
use Domain\User\Models\User;

test('auth user can see all topics', function () {
    $user = User::factory()->create();

    $topic = Topic::factory()
        ->hasArticles(3)
        ->create([
            'label' => 'Test Topic',
        ]);

    $this->be($user)
        ->get(route('topics.index'))
        ->assertSuccessful()
        ->assertJsonCount(1)
        ->assertJsonPath('data.0', [
            'id' => $topic->id,
            'label' => 'Test Topic',
            'articles_count' => 3,
        ]);
});

test('topics are sorted by label', function () {

    $user = User::factory()->create();

    $topics = Topic::factory(3)->create();

    $this->be($user)
        ->get(route('topics.index'))
        ->assertSuccessful()
        ->assertJsonPath(
            'data.*.label',
            $topics->pluck('label')->sort()->values()->toArray()
        );
});
