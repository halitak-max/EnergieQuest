<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Custom Dashboard Content -->
            <div class="container" style="max-width: 100%;">
                
                <!-- Welcome -->
                <div class="welcome-section text-center mb-6">
                    <h1 id="welcomeMessage" class="text-2xl font-bold">Hallo, {{ Auth::user()->name }}! 👋</h1>
                    <p>Willkommen bei EnergieQuest</p>
                </div>

                <!-- Level Card -->
                <div class="card bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <div class="level-info flex flex-col items-center justify-center text-center mb-5">
                        <div class="level-label mb-2 font-semibold text-center w-full">Aktuelles Level</div>
                        <div class="level-number w-full flex justify-center" id="currentLevel">
                            @if($currentLevel > 0)
                                <img src="{{ asset('assets/lvl' . $currentLevel . '.jpeg') }}" alt="Level {{ $currentLevel }}" class="mx-auto" style="height: 120px; width: auto; object-fit: contain;">
                            @else
                                <span class="text-4xl font-bold">0</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="progress-container">
                        <div class="progress-labels flex justify-between mb-1">
                            <span>Fortschritt zu Level <span id="nextLevelNum">{{ $currentLevel < 7 ? $currentLevel + 1 : 'MAX' }}</span></span>
                            <span id="progressText">
                                @if($currentLevel < 7)
                                    {{ $approvedReferrals - ($currentLevel > 0 ? ($thresholds[$currentLevel] ?? 0) : 0) }}/{{ $needed - ($currentLevel > 0 ? ($thresholds[$currentLevel] ?? 0) : 0) }} Empfehlungen
                                @else
                                    Max Level
                                @endif
                            </span>
                        </div>
                        <div class="progress-bar w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                            <div class="progress-fill bg-blue-600 h-2.5 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                        <div class="progress-text text-sm text-gray-500 mt-1" id="remainingText">
                            @if($currentLevel < 7)
                                Noch {{ $needed - $approvedReferrals }} genehmigte Empfehlung(en) bis Level {{ $currentLevel + 1 }}
                            @else
                                Maximales Level erreicht!
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="stats-grid grid grid-cols-2 gap-4 mb-6">
                    <div class="stat-card bg-white p-4 rounded shadow text-center">
                        <div class="stat-value text-xl font-bold text-green-600">{{ $approvedReferrals }}</div>
                        <div class="stat-label text-sm text-gray-600">Erfolgreiche Empfehlungen</div>
                    </div>
                    <div class="stat-card bg-white p-4 rounded shadow text-center">
                        <div class="stat-value text-xl font-bold" style="color: #FFBF00;">{{ $totalReferrals - $approvedReferrals }}</div>
                        <div class="stat-label text-sm text-gray-600">Ausstehend</div>
                    </div>
                </div>

                <!-- Referral Code -->
                <div class="card bg-white p-6 rounded shadow mb-6 text-center">
                    <h3 class="font-bold text-lg mb-4">Mein Empfehlungscode</h3>
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
                            <i class="fa-solid fa-share-nodes"></i> Link teilen
                        </button>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card bg-white p-6 rounded shadow">
                    <h3 class="font-bold text-lg mb-4">Schnellaktionen</h3>
                    <div class="quick-actions-grid grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('empfehlungen') }}" class="action-button flex flex-col items-center justify-center p-4 bg-gray-50 rounded hover:bg-gray-100">
                            <i class="fa-solid fa-user-plus action-icon text-green-500 text-2xl mb-2"></i>
                            <span class="action-label text-sm">Empfehlungen</span>
                        </a>
                        <a href="{{ route('gutscheine') }}" class="action-button flex flex-col items-center justify-center p-4 bg-gray-50 rounded hover:bg-gray-100">
                            <i class="fa-solid fa-gift action-icon text-orange-500 text-2xl mb-2"></i>
                            <span class="action-label text-sm">Gutscheine</span>
                        </a>
                        <a href="{{ route('uploads.index') }}" class="action-button flex flex-col items-center justify-center p-4 bg-gray-50 rounded hover:bg-gray-100">
                            <i class="fa-solid fa-cloud-arrow-up action-icon text-blue-500 text-2xl mb-2"></i>
                            <span class="action-label text-sm">Upload</span>
                        </a>
                        <a href="{{ route('spielregeln') }}" class="action-button flex flex-col items-center justify-center p-4 bg-gray-50 rounded hover:bg-gray-100">
                            <i class="fa-solid fa-bell action-icon text-purple-500 text-2xl mb-2"></i>
                            <span class="action-label text-sm">Infos</span>
                        </a>
                    </div>
                </div>
                
            </div>
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
