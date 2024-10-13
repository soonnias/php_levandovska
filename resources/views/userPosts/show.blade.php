<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ $post->description }}">
   
    <title>{{ $post->title }}</title>
    <!-- font icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/themify-icons/css/themify-icons.css') }}">
    <!-- Bootstrap + main styles -->
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

    <!-- Page Second Navigation -->
    <nav class="navbar custom-navbar navbar-expand-md navbar-light bg-primary sticky-top">
        <div class="container">
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">                     
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('userPosts.index') }}">Posts</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Of Page Second Navigation -->

    <!-- Page Header -->
    <header class="page-header page-header-mini">
        <h1 class="title">{{ $post->title }}</h1>
        <ol class="breadcrumb pb-0">
            <li class="breadcrumb-item"><a href="{{ route('userPosts.index') }}">Posts</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $post->title }}</li>
        </ol>
    </header>
    <!-- End Of Page Header -->

    <section class="container">
        <div class="page-container">
            <div class="page-content">
                <div class="card">
                    <div class="card-header pt-0">
                        <h3 class="card-title mb-4">{{ $post->title }}</h3>
                        <div class="blog-media mb-4">
                            <img src="{{$post->image}}" alt="{{ $post->title }}" class="w-100">
                            @foreach ($post->categories as $category)
                                <a href="#" class="badge badge-primary">#{{ $category->name }}</a>
                            @endforeach
                        </div>  
                        <small class="small text-muted">
                            <span>{{ $post->created_at->format('F d, Y')}}</span>
                            <span class="px-2">·</span>
                            <a href="#" class="text-muted">{{ $post->comments->count() }} Comments</a>
                            <span class="px-2">·</span>
                            <span class="text-muted">{{ $post->likes->count() }} Likes</span>
                            <span class="px-2">·</span>
                            
                            <!-- Іконка лайка -->
                            <form action="{{-- route('likes.toggle', $post->id) --}}"  style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-link p-0">
                                    @if ($userLiked)
                                        <i class="ti-heart text-danger"></i> <!-- Заповнене серце -->
                                    @else
                                        <i class="ti-heart"></i> <!-- Пусте серце -->
                                    @endif
                                </button>
                            </form>
                        </small>
                    </div>
                    <div class="card-body border-top">
                        <p class="my-3">{{ $post->description }}</p> 
                    </div>
                    
                    <!-- Comments Section -->
                    <div class="card-footer">
                         <h6 class="mt-5 mb-3 text-center"><a href="#" class="text-dark">Comments {{ $post->comments->count() }}</a></h6>
                        <hr>
                        @foreach ($post->comments as $comment)
                            <div class="media mt-4">
                                <img src="{{ asset('assets/imgs/avatar-' . ($comment->user->id % 4 + 1) . '.jpg') }}" class="mr-3 thumb-sm rounded-circle" alt="...">
                                <div class="media-body">
                                    <h6 class="mt-0">{{ $comment->user->username }}</h6>
                                    <p>{{ $comment->content }}</p>
                                    <a href="#" class="text-dark small font-weight-bold"><i class="ti-back-right"></i> Reply</a>
                                </div>
                            </div>
                        @endforeach

                        <!-- Comment Form -->
                        <h6 class="mt-5 mb-3 text-center"><a href="#" class="text-dark">Write Your Comment</a></h6>
                        <hr>
                        <form>
                            @csrf
                            <div class="form-row">
                                <div class="col-12 form-group">
                                    <textarea name="content" id="" cols="30" rows="5" class="form-control" placeholder="Enter Your Comment Here"></textarea>
                                </div>
                                <div class="form-group col-12">
                                    <button class="btn btn-primary btn-block">Post Comment</button>
                                </div>
                            </div>
                        </form>
                    </div>                  
                </div> 
            </div>
           <!-- Sidebar -->
            <div class="page-sidebar">
                <h6 class=" ">Категорії</h6>
                @foreach ($categories as $category)
                    <a href="{{ route('userPosts.index', [
                        'categories' => array_merge((array) request('categories'), [$category->category_id]),
                        'search' => '',
                        'from_date' => '',
                        'to_date' => ''
                    ]) }}" class="badge badge-primary m-1">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>        
        </div>
    </section>

    <!-- Page Footer -->
    <footer class="page-footer">
        <div class="container">
            <p class="border-top mb-0 mt-4 pt-3 small">&copy; <script>document.write(new Date().getFullYear())</script>, JoeBlog Created By <a href="https://www.devcrud.com" class="text-muted font-weight-bold" target="_blank">DevCrud.</a>  All rights reserved </p> 
        </div>      
    </footer>
    <!-- End of Page Footer -->

	<!-- core  -->
    <script src="{{ asset('assets/vendors/jquery/jquery-3.4.1.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap/bootstrap.bundle.js') }}"></script>

    <!-- JoeBLog js -->
    <script src="{{ asset('assets/js/joeblog.js') }}"></script>

</body>
</html>
