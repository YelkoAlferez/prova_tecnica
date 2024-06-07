<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <style>
        .dataTables_length label {
            font-size: 14px; /* Ajusta el tamaño de fuente */
        }
    
        .dataTables_length select {
            width: 100px; /* Ajusta el ancho del selector */
            display: inline-block; /* Asegúrate de que sea inline */
            padding: 5px 10px 5px 5px; /* Ajusta el padding para el selector */
            margin-left: 5px; /* Ajusta el margen izquierdo */
            -webkit-appearance: none; /* Elimina el estilo por defecto del navegador */
            -moz-appearance: none; /* Elimina el estilo por defecto del navegador */
            appearance: none; /* Elimina el estilo por defecto del navegador */
            background: url('data:image/svg+xml;utf8,<svg fill="%23333" height="24" viewBox="0 0 8 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 10px center;
            background-size: 16px 16px; /* Ajusta el tamaño del icono de flecha */
        }
    </style>
    @stack('styles')
    <!-- Scripts -->
    @stack('scripts')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Home
                </a>
                @if (Request::url() != route('categories.index'))
                    <a class="navbar-brand" href="{{ route('categories.index') }}">
                        Categories
                    </a>
                @endif
                @if (Request::url() != route('products.index'))
                    <a class="navbar-brand" href="{{ route('products.index') }}">
                        Products
                    </a>
                @endif
                @if (Request::url() != route('calendar.index'))
                    <a class="navbar-brand" href="{{ route('calendar.index') }}">
                        Calendar
                    </a>
                @endif
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

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
