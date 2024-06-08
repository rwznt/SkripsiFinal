<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <style>
      .mynav{
        background: rgb(2,0,36);
        background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(146,32,240,1) 100%);
      }
      .mynav a {
        margin-right: 10px;
        color: white !important;
        border-bottom: 2px solid transparent;
      }

      .mynav a:hover {
          border-bottom: 2px solid white;
      }

      .active a {
          border-bottom: 2px solid white;
      }
      ul .mymenu
      {
        background: rgb(2,0,36);
        background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(146,32,240,1) 100%);
      }
      .mymenu a:hover
      {
        background: rgb(2,0,36);
        background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(146,32,240,1) 100%);
      }

    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg shadow mynav">
    <div class="container">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item {{ Request()->is('home') ? 'active' : '' }}">
            <a class="nav-link " href="{{ url('home') }}"> Articreate </a>
          </li>
        </ul>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto ml-auto">
                <li class="nav-item">
                    <div class="justify-content-md-center">
                        <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="text" placeholder="Zoeken..." aria-label="Search" style="width: 600px;">

                            <button class="btn btn-info my-2 my-sm-0" type="submit">Search</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
            <ul class="navbar-nav ms-auto">

                @guest
                <ul class="navbar-nav ms-auto mydrop">
                    @if (Route::has('login'))
                        <li class="nav-item {{ Request()->is('login') ? 'active' : '' }}">
                            <a class="nav-link bi bi-box-arrow-in-right" href="{{ route('login') }}">  Login</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item {{ Request()->is('register') ? 'active' : '' }} ">
                            <a class="nav-link bi-person-plus" href="{{ route('register') }}">   Register</a>
                        </li>
                    @endif
                </ul>
                @endguest
                @auth
                @if (Auth::user()->level == 'admin')
                <ul class="navbar-nav ms-auto mydrop">
                <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle  bi bi-journals" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Manage Article
                    </a>
                    <ul class="dropdown-menu mymenu" aria-labelledby="navbarDropdown">
                      <li><a class="nav-link bi bi-journal-check" href="/item">  Review Article </a></li>
                      <li><a class="nav-link bi bi-bookmark-plus" href="/additem"> Publish Article </a></li>
                    </ul>
                  </li>
                  <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle  bi bi-person" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Profile
                    </a>
                    <ul class="dropdown-menu mymenu" aria-labelledby="navbarDropdown">
                      <li><a class="nav-link" href="#">{{ Auth::User()->name}}</a></li>
                      <li><a class="nav-link bi bi-person-gear" href="{{ url('profile') }}">  Edit Profile</a></li>
                      <li><a class="nav-link bi bi-person-lock" href="{{ route('password') }}">  Password</a></li>
                      <li><hr class="dropdown-divider bg-white"></li>
                      <li><a class="nav-link bi bi-box-arrow-right" href="{{ route('logout') }}">  Log out</a></li>
                    </ul>
                  </li>
                </ul>
                @endif
                @if (Auth::user()->level == 'member')
                <ul class="navbar-nav ms-auto mydrop">
                    <li class="nav-item {{ Request()->is('checkout') ? 'active' : '' }}">
                        <a class="nav-link bi bi-heart-fill" href="/checkout"> Interaction </a>
                      </li>
                      <li class="nav-item {{ Request()->is('history') ? 'active' : '' }}">
                        <a class="nav-link bi bi-pen" href="/history"> Create </a>
                      </li>
                  <li class="nav-item dropdown ">
                    <a class="nav-link dropdown-toggle  bi bi-person" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Profile
                    </a>
                    <ul class="dropdown-menu mymenu" aria-labelledby="navbarDropdown">
                      <li><a class="nav-link" href="#">{{ Auth::User()->name}}</a></li>
                      <li><a class="nav-link bi bi-person-gear" href="{{ url('profile') }}">  Edit Profile</a></li>
                      <li><a class="nav-link bi bi-person-lock" href="{{ route('password') }}">  Password</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="nav-link bi bi-box-arrow-right" href="{{ route('logout') }}">  Log out</a></li>
                    </ul>
                  </li>
                </ul>
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

