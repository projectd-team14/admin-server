<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BICYCLE SYSTEM</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/circle.css">
</head>
<body>
    <div id="app" class="main-view">
    @guest
        @if (Route::has('login') or Route::has('register'))
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        駐輪場管理システム-管理者用
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('新規登録') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('ログアウト') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        @endif
    @endguest
        @guest
            @if (Route::has('login'))
                <main>
                    @yield('content')
                </main>
            @elseif (Route::has('register'))
                <main>
                    @yield('content')
                </main>
            @endif
        @else
        <div class="row" style='height: 100vh; width: 102%'>
            <div class="col-md-2 p-0">
            </div>
                @include('navibar')    
            @if (Route::is('home'))
                <div class="col-md-10 p-0">
                    @include('home')
                </div>
            @elseif (Route::is('download'))
                <div class="col-md-10 p-0">
                    @include('download')
                </div>                

            @elseif (Route::is('chart'))
                <div class="col-md-10 p-0">
                    @include('chart')
                </div>
            @elseif (Route::is('chart_spot'))
                <div class="col-md-10 p-0">
                    @include('chartSpot')
                </div>
            @elseif (Route::is('camera'))
                <div class="col-md-10 p-0">
                    @include('camera')
                </div>
            @elseif (Route::is('user'))
                <div class="col-md-10 p-0">
                    @include('user')
                </div>
            @endif
        @endguest
        </div>
    </div>
</body>
</html>
