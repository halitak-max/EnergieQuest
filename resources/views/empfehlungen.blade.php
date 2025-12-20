<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Empfehlungen') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="sm:pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container" style="max-width: 100%;">

                <!-- Welcome -->
                <div class="welcome-section text-center mb-6">
                    <h1 class="text-2xl font-bold">Empfehlungen</h1>
                    <p>Lade Freunde ein und verdiene Belohnungen</p>
                </div>

                <!-- Stats -->
                <div class="card bg-white p-6 rounded shadow mb-6">
                    <h3 class="font-bold text-lg mb-4 text-center">Mein Status</h3>
                    <div class="stats-grid grid grid-cols-2 gap-4">
                        <div class="stat-card bg-gray-50 p-4 rounded text-center">
                            <div class="stat-value text-xl font-bold text-green-600">{{ $stats['success'] }}</div>
                            <div class="stat-label text-sm text-gray-600">Erfolgreich</div>
                        </div>
                        <div class="stat-card bg-gray-50 p-4 rounded text-center">
                            <div class="stat-value text-xl font-bold" style="color: #FFBF00;">{{ $stats['pending'] }}</div>
                            <div class="stat-label text-sm text-gray-600">Offen</div>
                        </div>
                    </div>
                </div>

                <!-- Referrals Table -->
                <div class="card bg-white p-6 rounded shadow mb-6">
                    <h3 class="font-bold text-lg mb-4 text-center">Meine Empfehlungen</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-center">Name</th>
                                    <th scope="col" class="px-6 py-3 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($referrals as $referral)
                                    <tr class="bg-white border-b">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap text-center">
                                            {{ $referral->referredUser->name ?? $referral->referredUser->full_name ?? 'Unbekannt' }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($referral->status == 0)
                                                <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">Registriert</span>
                                            @elseif($referral->status == 1)
                                                <span class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full">In Prüfung</span>
                                            @elseif($referral->status == 2)
                                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">Genehmigt</span>
                                            @else
                                                <span class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-100 rounded-full">Unbekannt</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">Noch keine Empfehlungen</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Invite Friends -->
                <div class="card bg-white p-6 rounded shadow text-center">
                    <h3 class="font-bold text-lg mb-4">Freunde einladen</h3>
                    <p class="text-gray-600 mb-4 text-sm">
                        Teile meinen persönlichen Code mit Freunden. Für jede erfolgreiche Anmeldung erhalte ich Guthaben!
                    </p>
                    <div class="referral-code-box bg-gray-100 p-3 rounded mb-4 font-mono text-xl">{{ Auth::user()->referral_code }}</div>
                    
                     <div x-data="{ 
                        share() {
                            const code = '{{ Auth::user()->referral_code }}';
                            const url = '{{ route('register', ['ref' => Auth::user()->referral_code]) }}';
                            const text = `Spare Energie und Geld mit EnergieQuest! Nutze meinen Code ${code} bei der Anmeldung: ${url}`;
                            
                            if (navigator.share) {
                                navigator.share({
                                    title: 'EnergieQuest Einladung',
                                    text: text,
                                    url: url
                                });
                            } else {
                                navigator.clipboard.writeText(text);
                                alert('Link kopiert!');
                            }
                        }
                    }">
                        <button @click="share" class="btn-share bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                            <i class="fa-solid fa-share-nodes"></i> Code teilen
                        </button>
                    </div>
                </div>

            </div>
            
            <div class="h-14 sm:hidden mt-3"></div>
        </div>
    </div>
    
    <!-- Bottom Nav -->
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

