{{-- resources/views/categories/create.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Додати категорію</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Назва категорії</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Створити</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Назад</a>
    </form>
@endsection
