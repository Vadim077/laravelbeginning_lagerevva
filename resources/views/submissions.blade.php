@extends('layouts.app')

@section('title', 'Все заявки')

@section('content')
    <h2>Все полученные данные из JSON файлов</h2>

    @if(empty($submissions))
        <p>Пока нет ни одной записи. <a href="{{ route('form.show') }}">Заполнить форму</a>.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Файл</th>
                    <th>Дата и время</th>
                    <th>Имя</th>
                    <th>Email</th>
                    <th>Сообщение</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $item)
                    <tr>
                        <td><code>{{ $item['file_name'] }}</code></td>
                        <td>{{ $item['created_at'] ?? '-' }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['email'] }}</td>
                        <td>{{ $item['message'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection