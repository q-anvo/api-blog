<?php

namespace Domain\Blog\Policies;

use Domain\Blog\Models\Article;
use Domain\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    public function view(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAuthor();
    }

    public function update(User $user, Article $article): bool
    {
        return $user->author?->id === $article->author_id;
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->author?->id === $article->author_id;
    }
}
