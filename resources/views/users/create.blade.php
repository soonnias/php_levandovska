{{-- resources/views/users/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Створити нового користувача</h1>

    {{-- Виведення повідомлень про помилки валідації --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Ім'я</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Підтвердження паролю</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Роль</label>
            <select class="form-select" id="role" name="role" required>
                <option value="user">Користувач</option>
                <option value="admin">Адміністратор</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Створити користувача</button>
    </form>
</div>
@endsection
