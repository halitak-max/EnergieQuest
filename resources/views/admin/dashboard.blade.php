<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EnergieQuest') }} Admin - Übersicht</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.svg') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen">
            @include('admin.partials.navigation')

            <!-- Page Content -->
            <main class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
                        <p class="mt-2 text-sm text-gray-600">Übersicht über alle Bereiche</p>
                    </div>

                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                        <a href="{{ route('admin.accepted-offers') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                        <i class="fa-solid fa-check-circle text-green-600 text-2xl"></i>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Angenommene Angebote</dt>
                                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['users_with_accepted_offer'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.users') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-blue-100 rounded-md p-3">
                                        <i class="fa-solid fa-users text-blue-600 text-2xl"></i>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Alle User</dt>
                                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.uploads') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-purple-100 rounded-md p-3">
                                        <i class="fa-solid fa-upload text-purple-600 text-2xl"></i>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Uploads</dt>
                                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['total_uploads'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.appointments') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-yellow-100 rounded-md p-3">
                                        <i class="fa-solid fa-calendar text-yellow-600 text-2xl"></i>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Termine</dt>
                                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['total_appointments'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.referrals') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-indigo-100 rounded-md p-3">
                                        <i class="fa-solid fa-user-plus text-indigo-600 text-2xl"></i>
                                    </div>
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">Referrals</dt>
                                            <dd class="text-2xl font-semibold text-gray-900">{{ $stats['total_referrals'] }}</dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Quick Links -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Schnellzugriff</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <a href="{{ route('admin.accepted-offers') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fa-solid fa-check-circle text-green-600 text-xl mr-3"></i>
                                    <span class="font-medium text-gray-900">Angenommene Angebote</span>
                                </a>
                                <a href="{{ route('admin.master-overview') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fa-solid fa-table text-blue-600 text-xl mr-3"></i>
                                    <span class="font-medium text-gray-900">Master-Übersicht</span>
                                </a>
                                <a href="{{ route('admin.uploads') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fa-solid fa-upload text-purple-600 text-xl mr-3"></i>
                                    <span class="font-medium text-gray-900">Uploads</span>
                                </a>
                                <a href="{{ route('admin.referrals') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fa-solid fa-user-plus text-indigo-600 text-xl mr-3"></i>
                                    <span class="font-medium text-gray-900">Referrals</span>
                                </a>
                                <a href="{{ route('admin.appointments') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fa-solid fa-calendar text-yellow-600 text-xl mr-3"></i>
                                    <span class="font-medium text-gray-900">Termine</span>
                                </a>
                                <a href="{{ route('admin.users') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    <i class="fa-solid fa-users text-blue-600 text-xl mr-3"></i>
                                    <span class="font-medium text-gray-900">Alle User</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
