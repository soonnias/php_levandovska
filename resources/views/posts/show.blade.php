{{-- resources/views/posts/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $post->title }}</h1>
    <p>{{ $post->content }}</p>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Назад до списку постів</a>
    <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Редагувати пост</a>
    <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Видалити пост</button>
    </form>
</div>
@endsection
