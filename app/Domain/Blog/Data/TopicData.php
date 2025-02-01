<?php

namespace Domain\Blog\Data;

use Spatie\LaravelData\Data;

class TopicData extends Data
{
    public function __construct(
        public int $id,
        public string $label,
    ) {}
}
