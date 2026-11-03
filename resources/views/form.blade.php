@extends('layouts.app')

@section('title', 'Отправка формы')

@section('content')
    <h2>Оставить отзыв / заявку</h2>

    {{-- Сообщение об успешном сохранении --}}
    @if(session('success'))
        <div class="alert-success">
            <strong>Успешно!</strong> {{ session('success') }}
        </div>
    @endif

    {{-- Вывод ошибок серверной валидации --}}
    @if($errors->any())
        <div class="alert-danger">
            <strong>Ошибки валидации:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('form.submit') }}" method="POST">
        @csrf {{-- Защита от CSRF --}}

        <div class="form-group">
            <label for="name">Ваше имя:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="email">Ваш Email:</label>
            <input type="text" id="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label for="message">Сообщение:</label>
            <textarea id="message" name="message" rows="4" class="form-control">{{ old('message') }}</textarea>
        </div>

        <button type="submit" class="btn">Отправить</button>
    </form>
@endsection