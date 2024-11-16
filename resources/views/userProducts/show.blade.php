@include('layouts.navigationUser')
<!-- End Of Page Header -->

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<section class="container">
    <div class="page-container">
        <div class="page-content">
            <div class="card">
                <div class="card-header pt-0">
                    <h3 class="card-title mb-4">{{ $product->name }}</h3>
                    <div class="product-media mb-4" style="text-align: center;">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-image" style="max-width: 600px; max-height: 600px; width: auto; height: auto;">
                    </div>
                    <small class="small text-muted">
                        <span>{{ $product->created_at->format('F d, Y')}}</span>
                        <span class="px-2">·</span>
                        <span class="product-price" style="font-size: 1.5rem; font-weight: bold;">${{ $product->price }}</span>
                    </small>
                </div>
                <div class="card-body border-top">
                    <p class="my-3">{{ $product->description }}</p>
                </div>

                <!-- Add to Cart Section -->
                <div class="card-footer">
                    @if($product->is_available)
                        @if(isset($cart) && $cart->id)
                            <form action="{{ route('cartItems.store', ['cartId' => $cart->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="form-group">
                                    <label for="quantity">Кількість:</label>
                                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1">
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Додати до кошика</button>
                            </form>
                        @else
                            <div class="alert alert-warning">
                                У вас ще немає кошика.
                                <a href="{{ route('carts.create', ['userId' => auth()->id()]) }}" class="btn btn-sm btn-primary">Створити кошик</a>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-danger">
                            Цей продукт недоступний для замовлення.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar with Product Categories -->
        <div class="page-sidebar">
            <h6 class="mb-3">Категорії продуктів</h6>
            @foreach ($categories as $category)
                <a href="{{ route('userProducts.index', ['categories' => array_merge((array) request('categories'), [$category->id])]) }}" class="badge badge-primary m-1">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Page Footer -->
<footer class="page-footer">
    <div class="container">
        <p class="border-top mb-0 mt-4 pt-3 small">&copy; <script>document.write(new Date().getFullYear())</script>, Shop Created By <a href="https://www.devcrud.com" class="text-muted font-weight-bold" target="_blank">DevCrud.</a>  All rights reserved </p>
    </div>
</footer>

<!-- core  -->
<script src="{{ asset('assets/vendors/jquery/jquery-3.4.1.js') }}"></script>
<script src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.js') }}"></script>

<!-- JoeBLog js -->
<script src="{{ asset('assets/js/joeblog.js') }}"></script>

</body>
</html>
