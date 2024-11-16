<!-- resources/views/layouts/navigation.blade.php -->

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
        <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('userPosts.index') }}">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('userProducts.index') }}">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('carts.show', ['userId' => auth()->id()]) }}">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('userOrders.index', ['userId' => auth()->id()]) }}">Orders</a>
                </li>
            </ul>

            <!-- Цей ul буде відображатися по правому краю завдяки ms-auto -->
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
