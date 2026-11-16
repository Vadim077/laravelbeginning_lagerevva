<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $query = Post::with(['category', 'tags', 'user'])->withCount('comments');

        if ($request->filled('scope')) {
            if ($request->input('scope') === 'published') {
                $query->published();
            } elseif ($request->input('scope') === 'popular') {
                $query->popular(50);
            }
        }

        if ($request->filled('category_id')) {
            $query->byCategory((int) $request->input('category_id'));
        }

        $posts = $query->latest()->get();
        $categories = Category::all();

        return view('posts.index', compact('posts', 'categories'));
    }

    public function create(): View
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
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
            'is_published' => $request->has('is_published'),
            'views_count' => $validated['views_count'] ?? 0,
        ]);

        if (!empty($validated['tags'])) {
            $post->tags()->sync($validated['tags']);
        }

        return redirect()->route('posts.index')->with('success', 'Пост успешно создан');
    }

    public function show(int $id): View
    {
        $post = Post::with(['category', 'tags', 'user', 'comments.user'])->findOrFail($id);
        $post->increment('views_count');

        return view('posts.show', compact('post'));
    }

    public function edit(int $id): View
    {
        $post = Post::with('tags')->findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'views_count' => 'nullable|integer|min:0',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $post->update([
            'category_id' => $validated['category_id'] ?? null,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_published' => $request->has('is_published'),
            'views_count' => $validated['views_count'] ?? 0,
        ]);

        $post->tags()->sync($validated['tags'] ?? []);

        return redirect()->route('posts.show', $post->id)->with('success', 'Пост успешно обновлен');
    }

    public function destroy(int $id): RedirectResponse
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Пост успешно удален');
    }

    public function addComment(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'body' => 'required|string|min:3',
        ]);

        $post = Post::findOrFail($id);
        $user = User::first();

        $post->comments()->create([
            'user_id' => $user?->id,
            'body' => $request->input('body'),
        ]);

        return redirect()->route('posts.show', $post->id)->with('success', 'Комментарий добавлен');
    }
}
