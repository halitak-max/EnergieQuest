<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EnergieQuest') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.svg') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Remix Icons -->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-4 sm:pt-12 bg-gradient-to-br from-blue-100 via-blue-50 to-blue-100">
            <div class="w-full sm:max-w-md text-left px-4 sm:px-0 mb-3">
                <x-energiequest-logo />
            </div>

            <div class="w-full sm:max-w-md mt-2 px-4 sm:px-0 relative z-10">
                <div class="bg-white shadow-md overflow-hidden rounded-lg sm:rounded-lg">
                    <div class="px-5 py-4">
                        {{ $slot }}
                    </div>
                </div>
            </div>

            @isset($footer)
                <div class="w-full sm:max-w-md mt-3 px-4 sm:px-0">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </body>
</html>
