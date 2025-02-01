<?php

namespace App\Blog\Controllers;

use App\Blog\Resources\Blog\TopicResource;
use Domain\Blog\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TopicController
{
    public function index(): JsonResource
    {
        $topics = Topic::query()
            ->withCount('articles')
            ->orderBy('label')
            ->get();

        return TopicResource::collection($topics);
    }

    public function show(Topic $topic): JsonResource
    {

        $topic->loadCount('articles');

        return TopicResource::make($topic);
    }

    public function store(Request $request): Response
    {
        $validator = Validator::make($request->all(), [
            'label' => ['required', 'string', 'min:3', 'max:255', 'unique:topics,label'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        Topic::query()->create($request->all());

        return response()->noContent();
    }

    public function update(Request $request, Topic $topic): Response
    {

        $validator = Validator::make($request->all(), [
            'label' => ['required', 'string', 'min:3', 'max:255', 'unique:topics,label'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $topic->update($request->all());

        return response()->noContent();
    }
}
