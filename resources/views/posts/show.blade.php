@extends('layouts.app')

@section('content')
<div class="container">
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


    <br>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Назад до списку постів</a>
    <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Редагувати пост</a>
    <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Видалити пост</button>
    </form>
</div>
@endsection
