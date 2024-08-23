<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>404 - Page Not Found</title>
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .navbar {
                background-color: #00AEEF;
            }

            .navbar-brand, .navbar-nav .nav-link {
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

            .navbar-toggler-icon {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%288, 8, 8, 0.5%29' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            }

            body {
                font-family: 'Nunito', sans-serif;
                background-color: #ffffff;
                color: #000000;
            }

            .container {
                padding-top: 50px;
                padding-bottom: 50px;
            }

            footer {
                background-color: #f8f9fa;
                padding: 20px 0;
                position: fixed;
                left: 0;
                bottom: 0;
                width: 100%;
                text-align: center;
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
                        <li class="nav-item">
                            <a class="nav-link bi bi-box-arrow-in-right" href="{{ route('login') }}"> Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link bi bi-person-plus" href="{{ route('register') }}"> Register</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container text-center">
            <h1 class="mt-5">404 - Page Not Found</h1>
            <p class="lead">The page you are looking for does not exist.</p>
            <a class="btn btn-outline-light" href="{{ url('/') }}">Go to Homepage</a>
        </div>
        <footer>
            <p class="text-center text-muted">© 2024 Articreate</p>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>