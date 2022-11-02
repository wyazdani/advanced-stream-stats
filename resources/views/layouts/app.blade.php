<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{url('images/favico.ico')}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .ps-scrollbar-x-rail:hover,.ps-scrollbar-x:hover{
            display:none !important;
        }
    </style>
    @yield('title')

    <!-- Scripts -->
    {{--<script src="{{ asset('js/app.js') }}" defer></script>--}}

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ url('css/main.css') }}" rel="stylesheet">
</head>
<body>
<div id="wrapper" @if(empty(auth()->user())) class="login" @endif>
    @guest

    @else
        <header id="header">
            <div class="container-fluid">
                <a href="#" class="nav-opener"><i class="fal fa-bars"></i> </a>
                <div class="logo">
                    <h1>Streamlabs</h1>
                </div>
                <nav id="top-nav">
                    <ul class="icon-list">
                    </ul>
                </nav>
            </div>
        </header>
        <nav id="nav-sidebar">
            <div class="scrollbar">
                <ul>
                    <li class="menu-title">Dashboard</li>
                </ul>
            </div>
        </nav>
    @endguest

    @guest
        @yield('content')
    @else
        <main id="main">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
    @endguest

</div>
<script type="text/javascript" src="{{url('js/proper.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/main.js')}}"></script>
@yield('scripts')

</body>
</html>
