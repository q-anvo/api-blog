<?php

namespace Domain\Blog\Policies;

use Domain\Blog\Models\Topic;
use Domain\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return $user->isAuthor();
    }

    public function update(User $user, Topic $Topic): bool
    {
        return $user->isAuthor();
    }

    public function delete(User $user, Topic $Topic): bool
    {
        return $user->isAuthor();
    }
}
