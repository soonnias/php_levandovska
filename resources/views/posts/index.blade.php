{{-- resources/views/posts/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
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
                <th>Зображення</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->category->name ?? 'Без категорії' }}</td>
                    <td>
                        @if($post->image_path)
                            <img src="{{ asset('storage/' . $post->image_path) }}" width="100" alt="{{ $post->title }}">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Редагувати</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Видалити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
