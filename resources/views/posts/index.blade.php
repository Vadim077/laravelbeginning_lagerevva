@extends('layouts.app')

@section('title', 'Список постов')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Публикации</h2>
        <a href="{{ route('posts.create') }}" class="btn" style="background: #27ae60; text-decoration: none;">+ Добавить пост</a>
    </div>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div style="background: #f1f2f6; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
        <strong>Фильтры:</strong>
        <div style="margin-top: 8px; display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('posts.index') }}" style="padding: 5px 10px; background: #dfe4ea; text-decoration: none; border-radius: 4px; color: #333;">Все</a>
            <a href="{{ route('posts.index', ['scope' => 'published']) }}" style="padding: 5px 10px; background: #2ed573; color: white; text-decoration: none; border-radius: 4px;">Только опубликованные</a>
            <a href="{{ route('posts.index', ['scope' => 'popular']) }}" style="padding: 5px 10px; background: #ff4757; color: white; text-decoration: none; border-radius: 4px;">Популярные</a>
            <span style="border-left: 2px solid #ccc; margin: 0 5px;"></span>
            @foreach($categories as $category)
                <a href="{{ route('posts.index', ['category_id' => $category->id]) }}" style="padding: 5px 10px; background: #70a1ff; color: white; text-decoration: none; border-radius: 4px;">{{ $category->name }}</a>
            @endforeach
        </div>
    </div>

    @if($posts->isEmpty())
        <p>Постов не найдено.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Заголовок</th>
                    <th>Категория</th>
                    <th>Теги</th>
                    <th>Автор</th>
                    <th>Просмотры</th>
                    <th>Комментарии</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>
                            <a href="{{ route('posts.show', $post->id) }}" style="font-weight: bold; color: #2980b9; text-decoration: none;">
                                {{ $post->title }}
                            </a>
                        </td>
                        <td>
                            @if($post->category)
                                <span style="background: #e8f4fd; color: #1e88e5; padding: 3px 8px; border-radius: 12px; font-size: 12px;">
                                    {{ $post->category->name }}
                                </span>
                            @else
                                <span style="color: #999;">—</span>
                            @endif
                        </td>
                        <td>
                            @forelse($post->tags as $tag)
                                <span style="background: #eee; padding: 2px 6px; border-radius: 4px; font-size: 11px;">#{{ $tag->name }}</span>
                            @empty
                                <span style="color: #aaa;">—</span>
                            @endforelse
                        </td>
                        <td>{{ $post->user?->name ?? '—' }}</td>
                        <td>{{ $post->views_count }}</td>
                        <td>{{ $post->comments_count }}</td>
                        <td>
                            @if($post->is_published)
                                <span style="color: green; font-weight: bold;">Опубликован</span>
                            @else
                                <span style="color: #e67e22;">Черновик</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('posts.edit', $post->id) }}" style="color: #f39c12; margin-right: 8px; text-decoration: none;">Изменить</a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Удалить пост?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; padding: 0;">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
