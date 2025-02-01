<?php

namespace Domain\Blog\Actions;

use Domain\Blog\Data\ArticleData;
use Domain\Blog\Models\Article;
use Domain\User\Models\Author;

class CreateArticle
{
    public function execute(Author $author, ArticleData $data): Article
    {
        $article = $author->articles()->create(
            $data->only('title', 'summary', 'url')->toArray()
        );

        $article->topics()->sync($data->topics);

        return $article;
    }
}
