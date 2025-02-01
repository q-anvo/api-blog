<?php

namespace Domain\Blog\Data;

use Spatie\LaravelData\Data;

class ArticleData extends Data
{
    public function __construct(
        public string $title,
        public string $summary,
        public string $url,
        /** @var array<int> */
        public array $topics = [],
    ) {}
}
