<nav x-data="{ open: false, profileMenuOpen: false }" class="bg-white/90 backdrop-blur-xl shadow-sm border-b border-blue-100/50 sticky top-0 z-40 transition-all duration-300">
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
                <!-- Desktop Dropdown -->
                <div class="hidden sm:block">
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
                <!-- Mobile SS Button -->
                <button @click="profileMenuOpen = !profileMenuOpen" class="sm:hidden w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-semibold cursor-pointer hover:shadow-lg transition-all">
                    @php
                        $initials = strtoupper(substr(Auth::user()->name, 0, 2));
                    @endphp
                    {{ $initials }}
                </button>
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

    <!-- Mobile Profile Sidebar (von rechts) -->
    <div 
        x-show="profileMenuOpen"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300 transform"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        @click.away="profileMenuOpen = false"
        class="fixed inset-y-0 right-0 z-50 w-64 bg-white shadow-2xl sm:hidden"
        style="display: none;"
    >
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 bg-gradient-to-r from-blue-500 to-indigo-500">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center text-white font-semibold">
                    @php
                        $initials = strtoupper(substr(Auth::user()->name, 0, 2));
                    @endphp
                    {{ $initials }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-blue-100">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <button @click="profileMenuOpen = false" class="text-white hover:text-gray-200 transition-colors">
                <i class="ri-close-line text-2xl"></i>
            </button>
        </div>

        <!-- Sidebar Menu -->
        <div class="py-4">
            <a 
                href="{{ route('profile.edit') }}" 
                @click="profileMenuOpen = false"
                class="flex items-center gap-3 px-6 py-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors border-l-4 border-transparent hover:border-blue-500"
            >
                <i class="ri-user-line text-xl"></i>
                <span class="font-medium">{{ __('Profil') }}</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button 
                    type="submit"
                    @click="profileMenuOpen = false"
                    class="w-full flex items-center gap-3 px-6 py-4 text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors border-l-4 border-transparent hover:border-red-500 text-left"
                >
                    <i class="ri-logout-box-line text-xl"></i>
                    <span class="font-medium">{{ __('Abmelden') }}</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Overlay für Mobile Sidebar -->
    <div 
        x-show="profileMenuOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="profileMenuOpen = false"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 sm:hidden"
        style="display: none;"
    ></div>
</nav>
