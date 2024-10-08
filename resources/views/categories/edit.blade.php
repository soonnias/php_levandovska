{{-- resources/views/categories/edit.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Редагувати категорію</h1>

    {{-- помилки валідації --}}
    @include('layouts.validation-errors')

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Назва категорії</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
        </div>
        <button type="submit" class="btn btn-success">Оновити</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Назад</a>
    </form>
@endsection
