<nav x-data="{ open: false }" class="bg-white/90 backdrop-blur-xl shadow-sm border-b border-blue-100/50 sticky top-0 z-40 transition-all duration-300 hidden sm:block">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo (Left) -->
            <div class="flex items-center">
                <x-energiequest-logo />
            </div>

            <!-- Navigation Links (Center) -->
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

            <!-- Settings Dropdown (Right) -->
            <div class="flex items-center space-x-3">
                <div class="hidden sm:block text-right">
                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-semibold cursor-pointer hover:shadow-lg transition-all">
                            @php
                                $initials = strtoupper(substr(Auth::user()->name, 0, 2));
                            @endphp
                            {{ $initials }}
                        </div>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Abmelden') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('uploads.index')" :active="request()->routeIs('uploads.*')">
                {{ __('Angebot') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('empfehlungen')" :active="request()->routeIs('empfehlungen')">
                {{ __('Empfehlungen') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('gutscheine')" :active="request()->routeIs('gutscheine')">
                {{ __('Gutscheine') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('datenschutz')" :active="request()->routeIs('datenschutz')">
                {{ __('Datenschutz') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Abmelden') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
