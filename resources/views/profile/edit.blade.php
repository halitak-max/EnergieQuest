<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="pt-6 sm:py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl mx-auto text-center">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl mx-auto text-center">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl mx-auto text-center">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 text-center">
                                {{ __('Datenschutz') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 text-center">
                                {{ __('Lesen Sie unsere Datenschutzerklärung.') }}
                            </p>
                        </header>
                        <div class="mt-6 flex justify-center">
                            <a href="{{ route('datenschutz') }}">
                                <x-secondary-button>
                                    {{ __('Zur Datenschutzerklärung') }}
                                </x-secondary-button>
                            </a>
                        </div>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl mx-auto text-center">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 text-center">
                                {{ __('Abmelden') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 text-center">
                                {{ __('Melden Sie sich von Ihrem Konto ab.') }}
                            </p>
                        </header>
                        <form method="POST" action="{{ route('logout') }}" class="mt-6 flex justify-center">
                            @csrf
                            <x-primary-button style="background-color: #FFBF00;">
                                {{ __('Abmelden') }}
                            </x-primary-button>
                        </form>
                    </section>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
                <div class="max-w-xl mx-auto text-center">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <!-- Spacer for mobile bottom nav -->
            <div class="h-16 sm:hidden mt-6"></div>
        </div>
    </div>

    <!-- Bottom Nav (Mobile) -->
    <nav class="bottom-nav fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 flex justify-around py-2 sm:hidden z-50">
        <a href="{{ route('dashboard') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-house nav-icon text-xl"></i>
            <span class="text-xs mt-1">Home</span>
        </a>
        <a href="{{ route('empfehlungen') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('empfehlungen') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-user-plus nav-icon text-xl"></i>
            <span class="text-xs mt-1">Empfehlungen</span>
        </a>
        <a href="{{ route('gutscheine') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('gutscheine') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-ticket nav-icon text-xl"></i>
            <span class="text-xs mt-1">Gutscheine</span>
        </a>
        <a href="{{ route('uploads.index') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('uploads.*') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-cloud-arrow-up nav-icon text-xl"></i>
            <span class="text-xs mt-1">Uploads</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('profile.edit') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-regular fa-user nav-icon text-xl"></i>
            <span class="text-xs mt-1">Profil</span>
        </a>
    </nav>
</x-app-layout>
