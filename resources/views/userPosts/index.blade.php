<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with JoeBLog landing page.">
    <meta name="author" content="Devcrud">
    <title>JoeBLog | Blog Template</title>
    <!-- font icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/themify-icons/css/themify-icons.css') }}">
    <!-- Bootstrap + JoeBLog main styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/joeblog.css') }}">
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">

    <!-- First Navigation -->
    <nav class="navbar navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/imgs/logo.svg') }}" alt="Logo">
            </a>
            <div class="socials">
                <a href="#"><i class="ti-facebook"></i></a>
                <a href="#"><i class="ti-twitter"></i></a>
                <a href="#"><i class="ti-pinterest-alt"></i></a>
                <a href="#"><i class="ti-instagram"></i></a>
                <a href="#"><i class="ti-youtube"></i></a>
            </div>
        </div>
    </nav>
    <!-- End Of First Navigation -->

    <!-- Second Navigation -->
    <nav class="navbar custom-navbar navbar-expand-md navbar-light bg-primary sticky-top">
        <div class="container">
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Of Second Navigation -->
    
    <!-- page-header -->
    <header class="page-header" style="display: flex; flex-direction: column; justify-content: center; text-align: center; color: black;">
        <h1>Блог про психологію та саморозвиток</h1>
        <h2>Joe Mitchell</h2>
    </header>
    <!-- end of page header -->

    <div class="container">
        <section>
            <div class="feature-posts">
                <a href="" class="feature-post-item">                       
                    <span>Featured Posts</span>
                </a>
                <a href="" class="feature-post-item">
                    <img src="../../assets/imgs/img-1.jpg" class="w-100" alt="">
                    <div class="feature-post-caption">Incidunt Quaerat</div>
                </a>
                <a href="" class="feature-post-item">
                    <img src="../../assets/imgs/img-2.jpg" class="w-100" alt="">
                    <div class="feature-post-caption">Culpa Ducimus</div>
                </a>
                <a href="" class="feature-post-item">
                    <img src="../../assets/imgs/img-3.jpg" class="w-100" alt="">
                    <div class="feature-post-caption">Temporibus Simile</div>
                </a>
                <a href="" class="feature-post-item">
                    <img src="../../assets/imgs/img-4.jpg" class="w-100" alt="">
                    <div class="feature-post-caption">Adipisicing</div>
                </a>
            </div>
        </section>
        <hr>
        
        <!-- Page Content -->
        <div class="page-container">
            <div class="page-content">
                <div class="row">
                    @if($posts->isEmpty())
                        <div class="col-12 text-center">
                            <h3>Немає постів за заданими критеріями</h3>
                        </div>
                    @else
                        @foreach($posts as $post)
                            <div class="col-lg-6 col-md-6 mb-4">
                                <div class="card text-center rounded shadow-sm">
                                    <div class="card-header p-0">
                                        <img src="{{ $post->image }}" alt="{{ $post->title }}" class="card-img-top fixed-img">
                                        @foreach($post->categories as $category)
                                            <a href="#" class="badge badge-primary">#{{ $category->name }}</a>
                                        @endforeach
                                    </div>
                                    <div class="card-body px-0">
                                        <h5 class="card-title mb-2">{{ $post->title }}</h5>
                                        <small class="small text-muted">{{ $post->created_at->format('F d, Y') }}
                                            <span class="px-2">-</span>
                                            <a href="#" class="text-muted">{{ $post->comments->count() }} Comments</a>
                                            <span class="px-2">-</span>
                                            <a href="#" class="text-muted">{{ $post->likes->count() }} Likes</a>
                                        </small>
                                        <p class="my-2">{{ Str::limit($post->description, 150) }}</p>
                                    </div>
                                    <div class="card-footer p-0 text-center">
                                        <a href="{{ route('userPosts.show', $post) }}" class="btn btn-outline-dark btn-sm">READ MORE</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="page-sidebar text-center">
                <h6 class="sidebar-title section-title mb-4 mt-3">Фільтрування постів</h6>
                <form id="filter-form" action="{{ route('userPosts.index') }}" method="GET">
                    <div class="form-group">
                        <label for="category">Категорії:</label>
                        <select name="categories[]" class="form-control" id="category" multiple>
                            @foreach($categories as $category)
                                <option value="{{ $category->category_id }}" {{ in_array($category->category_id, request()->categories ?? []) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>                
                    <div class="form-group">
                        <label for="from_date">З дати:</label>
                        <input type="date" name="from_date" id="from_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="to_date">По дату:</label>
                        <input type="date" name="to_date" id="to_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="search">Пошук за назвою:</label>
                        <input type="text" name="search" id="search" class="form-control">
                    </div>
                    
                    @if(!empty($activeFilters['categories']) || !empty($activeFilters['search']) || !empty($activeFilters['from_date']) || !empty($activeFilters['to_date']))
                        <div class="active-filters mb-4">
                            <h6>Активні фільтри:</h6>
                            <ul class="list-group">
                                @if(!empty($activeFilters['categories']))
                                    <li class="list-group-item">
                                        Категорії: 
                                        @foreach($categories->whereIn('category_id', $activeFilters['categories']) as $category)
                                            <span class="badge badge-primary">{{ $category->name }}</span>
                                        @endforeach
                                    </li>
                                @endif
                                @if(!empty($activeFilters['search']))
                                    <li class="list-group-item">Пошук: "{{ $activeFilters['search'] }}"</li>
                                @endif
                                @if(!empty($activeFilters['from_date']))
                                    <li class="list-group-item">З дати: {{ $activeFilters['from_date'] }}</li>
                                @endif
                                @if(!empty($activeFilters['to_date']))
                                    <li class="list-group-item">По дату: {{ $activeFilters['to_date'] }}</li>
                                @endif
                            </ul>
                        </div>
                    @endif

                    <!-- Кнопки для фільтрації -->
                    <button type="submit" class="btn btn-primary">Застосувати фільтри</button>
                    <a href="{{ route('userPosts.index') }}" class="btn btn-secondary" style="margin: 10px 0px">Очистити фільтри</a>
                </form>        
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>
</html>
