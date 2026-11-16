@extends('layouts.app')

@section('title', 'Создать пост')

@section('content')
    <a href="{{ route('posts.index') }}" style="text-decoration: none; color: #2980b9;">&larr; Назад к списку</a>
    <h2 style="margin-top: 15px;">Создание нового поста</h2>

    @if($errors->any())
        <div class="alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Заголовок поста:</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="category_id">Категория:</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">-- Без категории --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Теги:</label>
            <div style="display: flex; gap: 15px; flex-wrap: wrap; margin-top: 5px;">
                @foreach($tags as $tag)
                    <label style="font-weight: normal;">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                        #{{ $tag->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label for="content">Текст поста:</label>
            <textarea id="content" name="content" rows="6" class="form-control" required>{{ old('content') }}</textarea>
        </div>

        <div class="form-group">
            <label for="views_count">Количество просмотров:</label>
            <input type="number" id="views_count" name="views_count" class="form-control" value="{{ old('views_count', 0) }}" min="0">
        </div>

        <div class="form-group">
            <label style="font-weight: normal;">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                <strong>Опубликовать сразу</strong>
            </label>
        </div>

        <button type="submit" class="btn" style="background: #27ae60;">Сохранить пост</button>
    </form>
@endsection
