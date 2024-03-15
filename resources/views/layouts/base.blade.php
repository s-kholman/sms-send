<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>@yield('title') </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</head>
<body>

<div class="container-fluid">
    <header class="blog-header py-3 ">
        <div class="row flex-nowrap justify-content-between align-items-center ">
            <div class="col-4 pt-1"></div>

            <div class="col-4 text-center">
                <label class="blog-header-logo text-dark">Админ панель рассылки SMS сообщений</label>
                <a hidden class="blog-header-logo text-dark" href="#">Large</a>
            </div>
            @guest
            <div class="col-4 d-flex justify-content-end align-items-center">
                <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Вход/Регистрация</a>
            </div>
            @endguest
            @auth

                <div class="col-1 d-flex justify-content-end align-items-center">
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                        {{ __('Выйти') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            @endauth

        </div>
    </header>
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                @auth
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="/clients" class="nav-link align-middle px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Клиенты</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/report" class="nav-link px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Отчеты</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/mailing" class="nav-link px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Рассылка</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/analytical" class="nav-link px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Аналитика</span></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link align-middle px-0" href="/smsc" class="nav-link px-0">
                            <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Интеграция с SMSC</span></a>
                    </li>


                </ul>
                @endauth

            </div>
        </div>
        <div class="col py-3">
            @yield('info')
            @yield('content')
        </div>
    </div>
</div>


</body>
</html>
