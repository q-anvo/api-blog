<?php

namespace App\Blog\Controllers;

use App\Blog\Resources\User\AuthorResource;
use Domain\User\Models\Author;
use Domain\User\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class AuthorController
{
    public function index(): JsonResource
    {
        $authors = Author::query()
            ->with('user')
            ->withCount('articles')
            ->get();

        return AuthorResource::collection($authors);
    }

    public function store(#[CurrentUser()] User $user): Response
    {
        $user->author()->create();

        return response()->noContent();
    }
}
