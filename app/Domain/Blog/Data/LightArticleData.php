<?php

namespace Domain\Blog\Data;

use Spatie\LaravelData\Data;

class LightArticleData extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public string $summary,
    ) {}
}
