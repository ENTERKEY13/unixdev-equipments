<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UnixdevEquipment') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- Vue --}}
{{--    <script src="https://cdn.jsdelivr.net/npm/vue@3"></script>--}}
{{--    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>--}}


    {{-- Bootstrp --}}
    <link rel="stylesheet" href="{{ asset('assets/font/Sarabun/sarabun.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/framework/bootstrap5/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/framework/font-awesome/css/all.min.css') }}">

    <!-- Add jQuery before DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables script and CSS -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @stack('css')
        <style>
            a:hover, i:hover {
                color: #3eb57d !important;
            }
        </style>
    @yield('css')
</head>
<body>
    @stack('js')
    @yield('js')
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route(Auth::user() && Auth::user()->is_admin ? 'admin.unix.equipment_list' : 'user.unix.equipment_list') }}">
                    {{ config('app.name', 'UnixdevEquipment') }}
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
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <div class="d-flex gap-3 align-items-center">
                                    @if (Auth::user()->is_admin)
                                        <a class="nav-link" href="{{ route('admin.unix.user_equipment_list') }}">
                                            User Equipment List
                                        </a>
                                    @endif
                                    <a class="nav-link" href="{{ route(Auth::user() && Auth::user()->is_admin ? 'admin.unix.equipment_list' : 'user.unix.equipment_list') }}">
                                        Equipment List
                                    </a>
                                    <a class="nav-link" href="{{ route(Auth::user() && Auth::user()->is_admin ? 'admin.unix.equipment' : 'user.unix.equipment') }}">
                                        Equipment Form
                                    </a>
{{--                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
                                    <div class="d-flex align-items-center">
                                        <a class="nav-link" href="#">
                                            {{ Auth::user()->name }}
                                        </a>
                                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
