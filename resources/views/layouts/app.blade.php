<!DOCtype html>
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

    <!--Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

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
            <span class="nav-dropdown">
                <a class="dropdown-toggle @yield('event-header')" href="#" id="eventDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Events
                </a>
                <div class="dropdown-menu" aria-labelledby="eventDropdown">
                    <a class="dropdown-item" href="{{ url('event') }}">Upcoming Events</a>
                    @if(Auth::check())
                        <a class="dropdown-item" href="{{ route('event.add', ['id' => Auth::user()->id]) }}">Add New Event</a>
                        @if((Auth::user()->hasRole('organizer')) or (Auth::user()->hasRole('admin')))
                            <a class="dropdown-item" href="{{ route('event.myevents', ['id' => Auth::user()->id])}}">My Events</a>
                        @endif
                    @endif
                </div>
            </span>
            <a href="{{ url('organization') }}" @yield('organization-header')>Organizations</a>
            @if (Auth::check())
                @if((Auth::user()->hasRole('admin')))
                    <span class='nav-dropdown'>
                        <a class="dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Admin
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('organizer') }}">Organizers</a>
                            <a class="dropdown-item" href="{{ url('admin/all-events') }}">All Events</a>
                            <a class="dropdown-item" href="">All Transactions</a>
                        </div>
                    </span>
                @endif
            @endif

        </byu-menu>
        <byu-user-info slot="user">
            @guest <!--only guest-->
                <a slot='login' href="/cas-login">Sign In</a>
                <a slot="logout" href="{{ route('logout') }}"></a>

            @else <!-- Logged in -->
            <a href="{{ route('user.index', ['user_id' => Auth::user()->id]) }}" slot="user-name">{{ auth()->user()->name }}</a>
            <a slot="logout" href="{{ route('logout') }}" onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            {{ Form::open(['url'=>route('logout'), 'method'=>'post', 'style'=>'display: none', 'id'=>'logout-form']) }}
            {{ Form::close() }}
            @endguest

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

