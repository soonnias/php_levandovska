<!-- resources/views/comments/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Коментарі до: {{ $post->title }}</h1>
    
    <form action="{{ route('comments.store', $post) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="content">Ваш коментар:</label>
            <textarea class="form-control" name="content" id="content" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Додати коментар</button>
    </form>

    <h2 class="mt-4">Список коментарів:</h2>
    @foreach($comments->reverse() as $comment)
        <div class="card mt-2">
            <div class="card-body">
                <p><strong>{{ $comment->user->username }}</strong></p> <!-- Username -->
                <p>{{ $comment->content }}</p> <!-- Comment content -->
                <p class="text-muted" style="font-size: 0.8rem;">{{ $comment->created_at->format('d-m-Y H:i') }}</p> <!-- Date and time -->
                <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Видалити</button>
                </form>
            </div>
        </div>
    @endforeach
</div>
@endsection
