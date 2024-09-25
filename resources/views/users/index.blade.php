{{-- resources/views/users/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Користувачі</h1>

        <!-- Форма пошуку та сортування -->
        <form method="GET" action="{{ route('users.index') }}" class="mb-3">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="input-group me-2">
                        <input type="text" name="search" class="form-control" placeholder="Пошук за username" value="{{ request()->input('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Пошук</button>
                        </div>
                    </div>
                </div>
    
                <div class="col-auto">
                    <div class="input-group me-2">
                        <select name="sort" id="sort" class="form-select" style="width:auto;">
                            <option value="asc" {{ request()->input('sort') == 'asc' ? 'selected' : '' }}>A-Я</option>
                            <option value="desc" {{ request()->input('sort') == 'desc' ? 'selected' : '' }}>Я-А</option>
                        </select>
                        <button class="btn btn-outline-secondary" type="submit">Сортувати</button>
                    </div>
                </div>
    
                <div class="col-auto">
                    <div class="input-group me-2">
                        <select name="role" id="role" class="form-select" style="width:auto;">
                            <option value="">Всі ролі</option>
                            <option value="user" {{ request()->input('role') == 'user' ? 'selected' : '' }}>Користувач</option>
                            <option value="admin" {{ request()->input('role') == 'admin' ? 'selected' : '' }}>Адмін</option>
                        </select>
                        <button class="btn btn-outline-secondary" type="submit">Фільтрувати</button>
                    </div>
                </div>                
    
                <div class="col-auto ms-2">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-danger">Скинути фільтри</a>
                </div>
    
                <div class="col-auto ms-2">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">+</a>
                </div>
            </div>
    
            <div class="row mt-2">
                <div class="col">
                    @if(request()->input('search') || request()->input('sort') || request()->input('role'))
                        <div class="alert alert-info">
                            <strong>Застосовані фільтри:</strong>
                            <ul>
                                @if(request()->input('search'))
                                    <li>Пошук: <strong>{{ request()->input('search') }}</strong></li>
                                @endif
                                @if(request()->input('sort'))
                                    <li>Сортування: <strong>{{ request()->input('sort') == 'asc' ? 'А-Я' : 'Я-А' }}</strong></li>
                                @endif
                                @if(request()->input('role'))
                                    <li>Роль: <strong>{{ ucfirst(request()->input('role')) }}</strong></li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            
        </form>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ім'я</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->user_id }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">Редагувати</a>

                    <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline-block">
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
