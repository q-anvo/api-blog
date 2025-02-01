<?php

namespace App\Blog\Controllers;

use App\Blog\Requests\ArticleRequest;
use App\Blog\Resources\Blog\ArticleResource;
use App\Blog\Resources\Blog\FullArticleResource;
use Domain\Blog\Actions\CreateArticle;
use Domain\Blog\Actions\UpdateArticle;
use Domain\Blog\Data\ArticleData;
use Domain\Blog\Models\Article;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ArticleController
{
    public function index(): JsonResource
    {
        $articles = Article::query()
            ->with('author.user', 'topics')
            ->withCount('topics')
            ->orderBy('title')
            ->get();

        return ArticleResource::collection($articles);
    }

    public function show(Article $article): JsonResource
    {
        $article->load('author.user', 'topics');

        return FullArticleResource::make($article);
    }

    public function store(ArticleRequest $request): JsonResource
    {
        $author = $request->user()->author;
        $data = ArticleData::from($request->all());

        $article = app(CreateArticle::class)->execute($author, $data);

        return FullArticleResource::make($article);
    }

    public function update(ArticleRequest $request, Article $article): Response
    {
        $data = ArticleData::from($request->all());

        app(UpdateArticle::class)->execute($article, $data);

        return response()->noContent();
    }

    public function destroy(Article $article): Response
    {
        $article->delete();

        return response()->noContent();
    }
}
