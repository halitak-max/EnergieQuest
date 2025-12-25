<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icon.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/icon.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/icon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-12" style="background-color: #C6DAF1;">
            <div class="w-full sm:max-w-md text-center px-4 sm:px-0 mb-4">
                <a href="/">
                    <img src="{{ asset('assets/logo.png') }}" alt="Logo" class="h-8 w-auto mx-auto fill-current text-gray-500 rounded-lg" style="max-width: 200px;" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-4 sm:px-0 relative z-10">
                <div class="bg-white shadow-md overflow-hidden rounded-lg sm:rounded-lg">
                    <div class="px-6 py-4">
                        {{ $slot }}
                    </div>
                </div>
            </div>

            @if (isset($footer))
                <div class="w-full sm:max-w-md mt-6 px-4 sm:px-0">
                    {{ $footer }}
                </div>
            @endif
        </div>
    </body>
</html>
