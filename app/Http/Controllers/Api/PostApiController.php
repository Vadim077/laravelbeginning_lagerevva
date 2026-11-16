<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostApiController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Post::with(['category', 'tags', 'user', 'comments.user']);

        if ($request->boolean('published', true)) {
            $query->published();
        }

        if ($request->has('popular')) {
            $query->popular((int) $request->input('popular', 10));
        }

        if ($request->filled('category_id')) {
            $query->byCategory((int) $request->input('category_id'));
        }

        $posts = $query->latest()->get();

        return PostResource::collection($posts);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'nullable|boolean',
            'views_count' => 'nullable|integer|min:0',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $user = User::first() ?? User::factory()->create();

        $post = Post::create([
            'user_id' => $user->id,
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_published' => $validated['is_published'] ?? true,
            'views_count' => $validated['views_count'] ?? 0,
        ]);

        if (!empty($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        $post->load(['category', 'tags', 'user', 'comments.user']);

        return (new PostResource($post))
            ->response()
            ->setStatusCode(201);
    }

    public function show(int $id): PostResource
    {
        $post = Post::with(['category', 'tags', 'user', 'comments.user'])->findOrFail($id);
        $post->increment('views_count');

        return new PostResource($post);
    }

    public function update(Request $request, int $id): PostResource
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'nullable|boolean',
            'views_count' => 'nullable|integer|min:0',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post->update($validated);

        if ($request->has('tags')) {
            $post->tags()->sync($validated['tags'] ?? []);
        }

        $post->load(['category', 'tags', 'user', 'comments.user']);

        return new PostResource($post);
    }

    public function destroy(int $id): JsonResponse
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json([
            'message' => 'Пост успешно удален',
            'id' => $id,
        ]);
    }
}
