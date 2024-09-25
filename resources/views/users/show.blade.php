{{-- resources/views/users/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Деталі користувача</h1>

    <div class="mb-3">
        <label class="form-label"><strong>Ім'я:</strong></label>
        <p>{{ $user->username }}</p>
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>Email:</strong></label>
        <p>{{ $user->email }}</p>
    </div>

    <div class="mb-3">
        <label class="form-label"><strong>Роль:</strong></label>
        <p>{{ $user->role }}</p>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">Назад</a>
</div>
@endsection
