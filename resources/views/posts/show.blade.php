@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <a href="{{ route('posts.index') }}" style="text-decoration: none; color: #2980b9;">&larr; Назад ко всем постам</a>

    @if(session('success'))
        <div class="alert-success" style="margin-top: 15px;">{{ session('success') }}</div>
    @endif

    <div style="margin-top: 20px;">
        <h2>{{ $post->title }}</h2>

        <div style="margin-bottom: 15px; color: #7f8c8d; font-size: 14px;">
            Автор: <strong>{{ $post->user?->name ?? 'Неизвестен' }}</strong> |
            Категория: <strong>{{ $post->category?->name ?? 'Без категории' }}</strong> |
            Просмотров: <strong>{{ $post->views_count }}</strong> |
            Статус: <strong>{{ $post->is_published ? 'Опубликован' : 'Черновик' }}</strong>
        </div>

        <div style="margin-bottom: 20px;">
            <strong>Теги:</strong>
            @forelse($post->tags as $tag)
                <span style="background: #eee; padding: 4px 8px; border-radius: 4px; font-size: 13px; margin-right: 5px;">#{{ $tag->name }}</span>
            @empty
                <span style="color: #999;">Тегов нет</span>
            @endforelse
        </div>

        <div style="font-size: 16px; line-height: 1.6; padding: 15px; background: #fafafa; border-radius: 6px; border: 1px solid #eee;">
            {!! nl2br(e($post->content)) !!}
        </div>

        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <a href="{{ route('posts.edit', $post->id) }}" class="btn" style="background: #f39c12; text-decoration: none;">Редактировать</a>
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Удалить этот пост?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="background: #e74c3c;">Удалить пост</button>
            </form>
        </div>
    </div>

    <div style="margin-top: 40px; border-top: 2px solid #eee; padding-top: 20px;">
        <h3>Комментарии ({{ $post->comments->count() }})</h3>

        @forelse($post->comments as $comment)
            <div style="background: #f8f9fa; border-left: 4px solid #3498db; padding: 10px 15px; margin-bottom: 12px; border-radius: 0 4px 4px 0;">
                <div style="font-size: 13px; color: #555; margin-bottom: 5px;">
                    <strong>{{ $comment->user?->name ?? 'Гость' }}</strong> • {{ $comment->created_at?->diffForHumans() }}
                </div>
                <div>{{ $comment->body }}</div>
            </div>
        @empty
            <p style="color: #999;">Пока нет комментариев.</p>
        @endforelse

        <form action="{{ route('posts.comments.store', $post->id) }}" method="POST" style="margin-top: 20px;">
            @csrf
            <div class="form-group">
                <label for="comment_body">Добавить комментарий:</label>
                <textarea name="body" id="comment_body" rows="3" class="form-control" placeholder="Напишите комментарий..." required></textarea>
            </div>
            <button type="submit" class="btn" style="background: #3498db;">Отправить комментарий</button>
        </form>
    </div>
@endsection
