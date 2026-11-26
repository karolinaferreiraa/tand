<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Viveiro') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:wght@600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="viveiro-app-body">
        <div class="viveiro-app">
            @include('layouts.navigation')

            <div class="viveiro-main">
                <header class="viveiro-topbar">
                    <div>
                        <p class="viveiro-topbar-kicker">MONITORAMENTO DE TANQUES</p>
                        <p class="viveiro-topbar-user">Olá, {{ auth()->user()->name }}</p>
                    </div>
                    <form class="viveiro-search" action="{{ route('tanques.index') }}" method="GET">
                        <label class="sr-only" for="busca-tanque">Buscar tanque</label>
                        <input id="busca-tanque" type="search" name="busca" placeholder="Buscar tanque...">
                        <button type="submit" aria-label="Buscar">⌕</button>
                    </form>
                    <a class="viveiro-profile-link" href="{{ route('profile.edit') }}">
                        {{ auth()->user()->name }}
                    </a>
                </header>

                @isset($header)
                    <div class="viveiro-page-heading">
                        {{ $header }}
                    </div>
                @endisset

                <main class="viveiro-content">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
