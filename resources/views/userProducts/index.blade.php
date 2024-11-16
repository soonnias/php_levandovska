@include('layouts.navigationUser')

<!-- page-header -->
<header class="page-header" style="display: flex; flex-direction: column; justify-content: center; text-align: center; color: black;">
    <h1>Продукти</h1>
    <h2>Наш магазин</h2>
</header>
<!-- end of page header -->

<div class="container">
    <!-- Page Content -->
    <div class="page-container">
        <div class="page-content">
            <div class="row" style="margin-top: 20px">
                @if($products->isEmpty())
                    <div class="col-12 text-center">
                        <h3>Немає продуктів за заданими критеріями</h3>
                    </div>
                @else
                    @foreach($products as $product)
                        <div class="col-lg-6 col-md-6 mb-4">
                            <div class="card text-center rounded shadow-sm">
                                <div class="card-header p-0">
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="card-img-top fixed-img">
                                    <a href="#" class="badge badge-primary">{{ $product->category->name }}</a>
                                </div>
                                <div class="card-body px-0">
                                    <h5 class="card-title mb-2">{{ $product->name }}</h5>
                                    <small class="small text-muted">
                                        Ціна: {{ $product->price }} грн
                                    </small>
                                    <p class="my-2">
                                        {{ Str::limit($product->description, 150) }}
                                    </p>
                                    @if(!$product->is_available)
                                        <p class="text-danger font-weight-bold">Недоступний</p>
                                    @endif
                                </div>
                                <div class="card-footer p-0 text-center">
                                    @if($product->is_available)
                                        <a href="{{ route('userProducts.show', $product->id) }}" class="btn btn-outline-dark btn-sm">Детальніше</a>
                                    @else
                                        <button class="btn btn-outline-secondary btn-sm" disabled>Недоступний</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="page-sidebar text-center">
            <h6 class="sidebar-title section-title mb-4 mt-3">Фільтрування продуктів</h6>
            <form id="filter-form" action="{{ route('userProducts.index') }}" method="GET">
                <div class="form-group">
                    <label for="category">Категорії:</label>
                    <select name="categories[]" class="form-control" id="category" multiple>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ in_array($category->id, request()->categories ?? []) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="from_price">Мінімальна ціна:</label>
                    <input type="number" name="from_price" id="from_price" class="form-control" value="{{ request('from_price') }}">
                </div>
                <div class="form-group">
                    <label for="to_price">Максимальна ціна:</label>
                    <input type="number" name="to_price" id="to_price" class="form-control" value="{{ request('to_price') }}">
                </div>
                <div class="form-group">
                    <label for="search">Пошук за назвою:</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}">
                </div>

                @if(!empty($activeFilters['categories']) || !empty($activeFilters['search']) || !empty($activeFilters['from_price']) || !empty($activeFilters['to_price']) || isset($activeFilters['availability']))
                    <div class="active-filters mb-4">
                        <h6>Активні фільтри:</h6>
                        <ul class="list-group">
                            @if(!empty($activeFilters['categories']))
                                <li class="list-group-item">
                                    Категорії:
                                    @foreach($categories->whereIn('id', $activeFilters['categories']) as $category)
                                        <span class="badge badge-primary">{{ $category->name }}</span>
                                    @endforeach
                                </li>
                            @endif
                            @if(!empty($activeFilters['search']))
                                <li class="list-group-item">Пошук: "{{ $activeFilters['search'] }}"</li>
                            @endif
                            @if(!empty($activeFilters['from_price']))
                                <li class="list-group-item">Мінімальна ціна: {{ $activeFilters['from_price'] }}</li>
                            @endif
                            @if(!empty($activeFilters['to_price']))
                                <li class="list-group-item">Максимальна ціна: {{ $activeFilters['to_price'] }}</li>
                            @endif

                        </ul>
                    </div>
                @endif

                <!-- Кнопки для фільтрації -->
                <button type="submit" class="btn btn-primary">Застосувати фільтри</button>
                <a href="{{ route('userProducts.index') }}" class="btn btn-secondary" style="margin: 10px 0px">Очистити фільтри</a>
            </form>

        </div>
    </div>
</div>

<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>
</html>
