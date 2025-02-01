<?php

namespace Domain\Blog\Actions;

use Domain\Blog\Data\ArticleData;
use Domain\Blog\Models\Article;

class UpdateArticle
{
    public function execute(Article $article, ArticleData $data): void
    {
        $article->update([
            'title' => $data->title,
            'summary' => $data->summary,
            'url' => $data->url,
        ]);

        $article->topics()->sync($data->topics);
    }
}
