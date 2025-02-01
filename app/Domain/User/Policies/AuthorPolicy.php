<?php

namespace Domain\User\Policies;

use Domain\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Container\Attributes\CurrentUser;

class AuthorPolicy
{
    use HandlesAuthorization;

    public function create(#[CurrentUser] User $user): bool
    {
        return ! $user->isAuthor();
    }
}
