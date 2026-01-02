<header class="bg-white/90 backdrop-blur-xl shadow-sm border-b border-blue-100/50 sticky top-0 z-40 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <x-energiequest-logo />
            </div>
            <nav class="hidden md:flex space-x-1">
                <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium rounded-xl cursor-pointer transition-all hover:bg-blue-100 hover:scale-105 {{ request()->routeIs('home') ? 'bg-blue-50 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-blue-50' }}">
                    Home
                </a>
                <a href="{{ route('uploads.index') }}" class="px-4 py-2 text-sm font-medium rounded-xl cursor-pointer transition-all hover:bg-blue-100 hover:scale-105 {{ request()->routeIs('uploads.*') ? 'bg-blue-50 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-blue-50' }}">
                    Angebot
                </a>
                <a href="{{ route('empfehlungen') }}" class="px-4 py-2 text-sm font-medium rounded-xl cursor-pointer transition-all hover:bg-blue-100 hover:scale-105 {{ request()->routeIs('empfehlungen') ? 'bg-blue-50 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-blue-50' }}">
                    Empfehlungen
                </a>
                <a href="{{ route('gutscheine') }}" class="px-4 py-2 text-sm font-medium rounded-xl cursor-pointer transition-all hover:bg-blue-100 hover:scale-105 {{ request()->routeIs('gutscheine') ? 'bg-blue-50 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-blue-50' }}">
                    Gutscheine
                </a>
                <a href="{{ route('datenschutz') }}" class="px-4 py-2 text-sm font-medium rounded-xl cursor-pointer transition-all hover:bg-blue-100 hover:scale-105 {{ request()->routeIs('datenschutz') ? 'bg-blue-50 text-gray-900' : 'text-gray-600 hover:text-gray-900 hover:bg-blue-50' }}">
                    Datenschutz
                </a>
            </nav>
            <div class="flex items-center space-x-3">
                <div class="hidden sm:block text-right">
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
                <div class="relative group">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-semibold cursor-pointer hover:shadow-lg transition-all">
                        @php
                            $initials = strtoupper(substr(Auth::user()->name, 0, 2));
                        @endphp
                        {{ $initials }}
                    </div>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <a href="{{ route('profile.edit') }}" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg cursor-pointer whitespace-nowrap">Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg cursor-pointer whitespace-nowrap">Abmelden</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

