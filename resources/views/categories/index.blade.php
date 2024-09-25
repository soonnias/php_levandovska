@extends('layouts.app')

@section('content')
    <h1>Категорії</h1>

   <!-- Форма пошуку та сортування -->
    <form method="GET" action="{{ route('categories.index') }}" class="mb-3">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="input-group me-2">
                    <input type="text" name="search" class="form-control" placeholder="Пошук за назвою" value="{{ request()->input('search') }}">
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

            <div class="col-auto ms-2">
                <a href="{{ route('categories.index') }}" class="btn btn-outline-danger">Скинути фільтри</a>
            </div>

            <div class="col-auto ms-2">
                <a href="{{ route('categories.create') }}" class="btn btn-primary">Додати категорію</a>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col">
                @if(request()->input('search') || request()->input('sort'))
                    <div class="alert alert-info">
                        <strong>Застосовані фільтри:</strong>
                        <ul>
                            @if(request()->input('search'))
                                <li>Пошук: <strong>{{ request()->input('search') }}</strong></li>
                            @endif
                            @if(request()->input('sort'))
                                <li>Сортування: <strong>{{ request()->input('sort') == 'asc' ? 'А-Я' : 'Я-А' }}</strong></li>
                            @endif
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        
    </form>


    

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Назва</th>
                <th>Дії</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories->reverse() as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Редагувати</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Видалити</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
