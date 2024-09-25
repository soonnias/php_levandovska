@extends('layouts.app')

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h1>{{ $post->title }}</h1>
    <p><strong>Дата створення:</strong> {{ $post->created_at->format('d-m-Y H:i') }}</p>
    <p><strong>Опис:</strong> {{ $post->description }}</p>
    <p><strong>Категорії:</strong>
        @if($post->categories->isNotEmpty())
            {{ implode(', ', $post->categories->pluck('name')->toArray()) }}
        @else
            Без категорії
        @endif
    </p>
    
    @if($post->image)
        <img src="{{ $post->image }}" width="300" style="margin: 20px;" alt="{{ $post->title }}" onerror="this.onerror=null; this.src='{{ asset('images/placeholder.jpg') }}';">
    @endif

    <p><strong>К-ть лайків:</strong> {{ $post->likes()->count() }}</p> <!-- Відображення кількості лайків -->

    @if(session('current_user_id')) <!-- Перевірка, чи є активний користувач -->
        @php
            $liked = $post->likes()->where('user_id', session('current_user_id'))->exists(); // Перевірка, чи користувач вже лайкнув пост
        @endphp

        <form action="{{ $liked ? route('likes.destroy', ['post' => $post, 'user' => session('current_user_id')]) : route('likes.store') }}" method="POST">
            @csrf
            @if($liked)
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Видалити лайк</button>
            @else
                <input type="hidden" name="post_id" value="{{ $post->post_id }}">
                <button type="submit" class="btn btn-success">Лайкнути</button>
            @endif
        </form>
    @else
        <p>Щоб лайкнути пост, будь ласка, спочатку оберіть користувача.</p>
    @endif

    <br>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Назад до списку постів</a>
    <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Редагувати пост</a>
    <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Видалити пост</button>
    </form>

    <a href="{{ route('comments.index', $post) }}" class="btn btn-info">Перейти до коментарів</a>
</div>
@endsection
