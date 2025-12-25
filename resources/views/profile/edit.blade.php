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
                                <x-secondary-button class="text-white border-gray-500 hover:bg-gray-600" style="background-color: #6B7280 !important;">
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

    <x-bottom-nav />
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prüfe ob IBAN und Geburtsdatum jetzt ausgefüllt sind
            @php
                $user = Auth::user();
                $fieldsComplete = !empty($user->iban) && !empty($user->birth_date);
            @endphp
            
            @if($fieldsComplete)
                // Wenn Felder ausgefüllt sind, entferne den Flag
                localStorage.removeItem('offerButtonClicked');
            @endif
        });
    </script>
</x-app-layout>
