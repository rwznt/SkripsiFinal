<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }} - Articreate</title>
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <style>
            .navbar {
                background-color: #00AEEF;
            }

            .navbar-nav .nav-link {
                color: white !important;
            }

            .navbar-nav .nav-link:hover {
                color: #007bff !important;
                text-decoration: none;
            }

            .navbar-toggler {
                border: none;
                outline: none;
            }

            .navbar-brand {
                color: white;
            }

            .navbar-toggler-icon {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%288, 8, 8, 0.5%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            }

            .category-scroll-wrapper {
                overflow-x: auto;
                white-space: nowrap;
                background-color: #E0F7FA;
                padding: 10px 0;
            }

            .category-scroll-wrapper .btn {
                border-radius: 20px;
                margin: 5px;
            }

            .welcome-section {
                background-color: #00AEEF;
                color: white;
                padding: 50px 0;
                text-align: center;
            }

            .welcome-section .btn {
                border-radius: 20px;
            }

            .category-scroll-wrapper {
                overflow-x: auto;
                overflow-y: hidden;
                white-space: nowrap;
            }

            .category-scroll-wrapper::-webkit-scrollbar {
                display: none;
            }

            .dropdown-menu .nav-link {
                color: black !important;
            }

            .dropdown-menu .nav-link:hover {
                color: black !important;
                text-decoration: underline;
            }

            .dropdown-item:hover {
                background-color: transparent !important;
            }

            .navbar-expand-lg .navbar-nav .nav-link {
                padding-right: 0.5rem;
                padding-left: 0.5rem;
            }

            .form-inline .input-group {
                width: 100%;
            }

            @media (min-width: 768px) {
                .form-inline .input-group {
                    width: 800px;
                }
            }

            .btn-outline-light {
                color: #007bff;
                border-color: #007bff;
            }

            .btn-outline-light:hover {
                color: #fff;
                background-color: #007bff;
                border-color: #007bff;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-expand-lg shadow mynav">
            <div class="container">
                <a class="navbar-brand" href="{{ url('home') }}">Articreate</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <form class="form-inline my-2 my-lg-0 mx-auto" action="{{ route('search.result') }}" method="GET">
                        <div class="input-group">
                            <input class="form-control mr-sm-2" type="text" name="q" placeholder="Search desired article" aria-label="Search">
                            <button class="btn btn-info my-2 my-sm-0" type="submit">Search</button>
                        </div>
                    </form>
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item {{ Request()->is('login') ? 'active' : '' }}">
                                    <a class="nav-link bi bi-box-arrow-in-right" href="{{ route('login') }}"> Login</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item {{ Request()->is('register') ? 'active' : '' }}">
                                    <a class="nav-link bi bi-person-plus" href="{{ route('register') }}"> Register</a>
                                </li>
                            @endif
                        @endguest
                        @auth
                            @if (Auth::user()->role == 'admin')
                                <li class="nav-item">
                                    <a class="nav-link bi bi-bell" href="{{ route('notifications.index') }}">
                                        Notifications
                                        @if (Auth::user()->unreadNotifications->count() > 0)
                                            <span class="badge badge-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle bi bi-journals" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Manage
                                    </a>
                                    <ul class="dropdown-menu mymenu" aria-labelledby="navbarDropdown">
                                        <li><a class="nav-link bi bi-journal-check" href="{{route('review')}}">Review Article</a></li>
                                    </ul>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle bi bi-person" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Profile
                                    </a>
                                    <ul class="dropdown-menu mymenu" aria-labelledby="navbarDropdown">
                                        <li><a class="nav-link" href="{{ route('user.detail', ['id' => Auth::id()]) }}">{{ Auth::user()->name }}</a></li>
                                        <li><a class="nav-link bi bi-person-gear" href="{{ route('profile') }}">Profile</a></li>
                                        <li><a class="nav-link bi bi-person-lock" href="{{ route('password') }}">Password</a></li>
                                        <li><hr class="dropdown-divider bg-white"></li>
                                        <li><a class="nav-link bi bi-box-arrow-right" href="{{ route('logout') }}">Log out</a></li>
                                    </ul>
                                </li>
                            @endif
                            @if (Auth::user()->role == 'user')
                                <li class="nav-item">
                                    <a class="nav-link bi bi-bell" href="{{ route('notifications.index') }}">
                                        Notifications
                                        @if (Auth::user()->unreadNotifications->count() > 0)
                                            <span class="badge badge-danger">{{ Auth::user()->unreadNotifications->count() }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item {{ Request()->is('create') ? 'active' : '' }}">
                                    <a class="nav-link bi bi-pen" href="{{ route('create') }}">Create</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle bi bi-person" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Profile
                                    </a>
                                    <ul class="dropdown-menu mymenu" aria-labelledby="navbarDropdown">
                                        <li><a class="nav-link" href="{{ route('user.detail', ['id' => Auth::id()]) }}">{{ Auth::user()->name }}</a></li>
                                        <li><a class="nav-link bi bi-person-gear" href="{{ route('profile') }}">Profile</a></li>
                                        <li><a class="nav-link bi bi-person-lock" href="{{ route('password') }}">Password</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <a class="nav-link bi bi-box-arrow-right" href="{{ route('logout') }}">Log out</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            @yield('content')
        </div>
        <footer>
            <ul class="justify-content-center border-bottom pb-3 mb-3 " disabled>
            </ul>
            <p class="text-center text-muted">© 2024 Articreate</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
