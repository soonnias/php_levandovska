@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Коментарі до поста: {{ $post->title }}</h2>

    <form action="{{ route('comments.store', $post) }}" method="POST">
        @csrf
        <div class="form-group">
            <textarea name="content" class="form-control" placeholder="Ваш коментар..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary mt-2">Додати коментар</button>
    </form>

    <hr>

    <h3>Список коментарів:</h3>
    @foreach($comments as $comment)
        <div class="comment">
            <p><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</p>
            <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Видалити</button>
            </form>
        </div>
        <hr>
    @endforeach
</div>
@endsection
