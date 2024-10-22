<!-- resources/views/layouts/navigation.blade.php -->
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

<nav class="navbar custom-navbar navbar-expand-md navbar-light bg-primary sticky-top">
    <div class="container">
        <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('userPosts.index') }}">Home</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item d-flex align-items-center">
                        <span class="nav-link me-2">{{ Auth::user()->username }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link p-0" style="cursor: pointer;">
                                Вийти
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
