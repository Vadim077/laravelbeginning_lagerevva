@extends('layouts.app')

@section('title', 'Редактировать пост')

@section('content')
    <a href="{{ route('posts.show', $post->id) }}" style="text-decoration: none; color: #2980b9;">&larr; Назад к посту</a>
    <h2 style="margin-top: 15px;">Редактирование поста #{{ $post->id }}</h2>

    @if($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.update', $post->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Заголовок поста:</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Категория:</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">-- Без категории --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Теги:</label>
            <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-top: 5px;">
                @php
                    $currentTags = old('tags', $post->tags->pluck('id')->toArray());
                @endphp
                @foreach($tags as $tag)
                    <label style="font-weight: normal;">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, $currentTags) ? 'checked' : '' }}>
                        #{{ $tag->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="content">Текст поста:</label>
            <textarea id="content" name="content" rows="6" class="form-control" required>{{ old('content', $post->content) }}</textarea>
        </div>

        <div class="form-group">
            <label for="views_count">Количество просмотров:</label>
            <input type="number" id="views_count" name="views_count" class="form-control" value="{{ old('views_count', $post->views_count) }}" min="0">
        </div>

        <div class="form-group">
            <label style="font-weight: normal;">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                <strong>Опубликовать</strong>
            </label>
        </div>

        <button type="submit" class="btn" style="background: #f39c12;">Обновить пост</button>
    </form>
@endsection
