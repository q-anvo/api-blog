<?php

declare(strict_types=1);

namespace Tests;

use Domain\User\Models\User;

trait Methods
{
    protected function beUser(): self
    {
        return $this->be(User::factory()->createOne());
    }
}
