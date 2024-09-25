@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Пости</h1>
    <a href="{{ route('posts.create') }}" class="btn btn-primary">Додати пост</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Заголовок</th>
                <th>Категорія</th>
                <th>Дата створення</th>
                <th>Дії</th>
                <th>Деталі</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>
                        @if($post->categories->isNotEmpty())
                            {{ implode(', ', $post->categories->pluck('name')->toArray()) }}
                        @else
                            Без категорії
                        @endif
                    </td>
                    <td>{{ $post->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Редагувати</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;" onsubmit="return confirm('Ви впевнені, що хочете видалити цей пост?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Видалити</button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-info">Переглянути</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
