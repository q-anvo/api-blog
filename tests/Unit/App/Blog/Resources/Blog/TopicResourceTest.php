<?php

/* @covers \App\Blog\Resources\Blog\TopicResource */

use App\Blog\Resources\Blog\TopicResource;
use Domain\Blog\Models\Topic;

it('formats the topic', function (): void {
    $topic = Topic::factory()->hasArticles(2)->createOne();
    $topic->loadCount('articles');

    $resource = (TopicResource::make($topic))->toArray(null);

    expect($resource)->toBe([
        'id' => $topic->id,
        'label' => $topic->label,
        'articles_count' => 2,
    ]);
});
