@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1>Пости</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

  <!-- Форма пошуку, сортування та фільтрації -->
    <form method="GET" action="{{ route('posts.index') }}" class="mb-3">
        <div class="row align-items-center">
            <div class="col-auto">
                <div class="input-group me-2">
                    <input type="text" name="search" class="form-control" placeholder="Пошук за заголовком" value="{{ request()->input('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Пошук</button>
                </div>
            </div>

            <div class="col-auto">
                <div class="input-group me-2">
                    <select name="sort_option" class="form-select" style="height: 38px;">
                        <option value="asc" {{ request()->input('sort_option') == 'asc' ? 'selected' : '' }}>А-Я</option>
                        <option value="desc" {{ request()->input('sort_option') == 'desc' ? 'selected' : '' }}>Я-А</option>
                        <option value="new" {{ request()->input('sort_option') == 'new' ? 'selected' : '' }}>За новизною</option>
                        <option value="old" {{ request()->input('sort_option') == 'old' ? 'selected' : '' }}>За старістю</option>
                    </select>
                    <button class="btn btn-outline-secondary w-auto" type="submit">Сортувати</button>
                </div>
            </div>
        
            <div class="col-auto">
                <button type="button" class="btn btn-outline-secondary" id="toggleCategories">Вибрати категорії</button>
                <div id="categoryCheckboxes" style="display: none;" class="mt-2">
                    @foreach($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->category_id }}" id="category_{{ $category->category_id }}" {{ in_array($category->category_id, request()->input('categories', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category_{{ $category->category_id }}">
                                {{ $category->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-outline-secondary" type="submit">Фільтрувати</button>
            </div>

            <div class="col-auto ms-2">
                <a href="{{ route('posts.index') }}" class="btn btn-outline-danger">Скинути фільтри</a>
            </div>
            <div class="col-auto ms-2">
                <a href="{{ route('posts.create') }}" class="btn btn-primary">+</a>
            </div>
        </div>
    </form>

    @if(request()->input('search') || request()->input('sort_option') || request()->input('categories'))
        <div class="row mt-2">
            <div class="col">
                <div class="alert alert-info">
                    <strong>Застосовані фільтри:</strong>
                    <ul>
                        @if(request()->input('search'))
                            <li>Пошук: <strong>{{ request()->input('search') }}</strong></li>
                        @endif
                        @if(request()->input('sort_option'))
                            <li>Сортування за заголовком: <strong>{{ request()->input('sort_option') == 'asc' ? 'А-Я' : 'Я-А' }}</strong></li>
                        @endif
                        @if(request()->input('categories'))
                            <li>Категорії: <strong>{{ implode(', ', $categories->whereIn('category_id', request()->input('categories'))->pluck('name')->toArray()) }}</strong></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.getElementById('toggleCategories').addEventListener('click', function() {
            const checkboxes = document.getElementById('categoryCheckboxes');
            checkboxes.style.display = checkboxes.style.display === "none" ? "block" : "none";
        });
    </script>



    <table class="table mt-3">
        <thead>
            <tr>
                <th>Заголовок</th>
                <th>Категорія</th>
                <th>Дата створення</th>
                <th>Дії</th>
                <th>Деталі</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>
                        @if($post->categories->isNotEmpty())
                            {{ implode(', ', $post->categories->pluck('name')->toArray()) }}
                        @else
                            Без категорії
                        @endif
                    </td>
                    <td>{{ $post->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">Редагувати</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;" onsubmit="return confirm('Ви впевнені, що хочете видалити цей пост?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Видалити</button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-info">Переглянути</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
