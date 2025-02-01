<?php

use App\Blog\Controllers\ArticleController;
use App\Blog\Controllers\AuthorController;
use App\Blog\Controllers\TopicController;
use Domain\User\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')
    ->get('user', function (Request $request) {
        return $request->user();
    });

Route::middleware('auth:sanctum')
    ->resource('articles', ArticleController::class);

Route::middleware('auth:sanctum')
    ->resource('topics', TopicController::class)
    ->only(['index', 'show', 'store', 'update']);

Route::middleware('auth:sanctum')
    ->post('authors', [AuthorController::class, 'store'])
    ->can('create', Author::class);
