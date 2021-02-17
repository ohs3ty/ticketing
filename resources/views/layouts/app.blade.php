<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset("bootstrap/css/bootstrap.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css">

    <!-- BYU components https://webcomponents.byu.edu -->
    <script async src="https://cdn.byu.edu/byu-theme-components/2.x.x/byu-theme-components.min.js"></script>
    <link rel="stylesheet" href="https://cdn.byu.edu/byu-theme-components/2.x.x/byu-theme-components.min.css" media="all">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <byu-header>
        <span slot="site-title">Event Ticketing</span>
        <byu-menu slot="nav" active-selector=".is-active">
            <a href="{{ url('home') }}" @yield('home-header')>Home</a>
            <div class="dropdown">
                <button class="dropdown-btn">Events</button>
                <div class="dropdown-child @yield('event-header')">
                    <a href="{{ url('events') }}">View All Events</a>
                    @if(Auth::check())
                        <a href="{{ route('addevent', ['id' => Auth::user()->id]) }}">Add New Event</a>
                    @endif
                </div>
            </div>
            @if (Auth::check()) 
                @if((Auth::user()->role == 'admin')) 
                    <a href="{{ url('admin') }}">Admin</a>
                @endif
            @endif
        </byu-menu>
        <byu-user-info slot="user">
            @guest
                @if(Route::has('login'))
                    <a slot='login' href="{{ route('login') }}">Sign In</a>
                    {{-- what it should be --}}
                    {{-- <a slot='login' href="/cas-login">Sign In</a> --}}
                @endif

                @if (Route::has('register'))
                        <a slot='register' href="{{ route('register') }}">Register</a>
                @endif
            @else
                <span slot='user-name'> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                <a slot='logout' href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                 Sign Out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endguest
            {{-- <a slot='logout' href="#">Sign Out</a>
            <span slot="user-name">UserFirstName</span> --}}
        </byu-user-info>
    </byu-header>
    <div id="app">
        <div class="container">
            <main class="py-4">
                @yield('content')
            </main>
    </div>
    </div>
</body>
</html>
