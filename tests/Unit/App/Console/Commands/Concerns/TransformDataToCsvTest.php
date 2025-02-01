<?php

use App\Console\Commands\Concerns\TransformsDataToCsv;
use Domain\Blog\Data\ArticleData;
use Domain\Blog\Data\TopicData;
use Domain\Blog\Models\Article;
use Domain\Blog\Models\Topic;

/* @covers \App\Console\Commands\Concerns\TransformsDataToCsv */

beforeEach(function (): void {
    $this->exportClass = new class
    {
        use TransformsDataToCsv;
    };

    $this->data = TopicData::class;

    $this->topics = Topic::factory(2)->sequence(
        ['id' => 1, 'label' => 'Topic 1'],
        ['id' => 2, 'label' => 'Topic 2'],
    )->create();

    Storage::fake();
});

it('generates a csv file', function (): void {
    $this->exportClass->generateCsvFile($this->topics, $this->data, 'test.csv');

    expect(Storage::disk()->exists('test.csv'))->toBeTrue();

    $content = Storage::disk()->get('test.csv');

    expect($content)->toEqual('id,label'.PHP_EOL.'1,Topic 1'.PHP_EOL.'2,Topic 2');
});

it('does not yet generate a file for complex data', function (): void {
    $articles = Article::factory(2)->hasTopics()->create();

    $this->expectException(InvalidArgumentException::class);

    $this->exportClass->generateCsvFile($articles, ArticleData::class, 'test.csv');

    expect(Storage::disk()->exists('test.csv'))->toBeFalse();

});
