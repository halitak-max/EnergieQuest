<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gutscheine & Level') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container" style="max-width: 100%;">

                <!-- Header Stats -->
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold">Gutscheine & Level</h2>
                </div>

                <!-- Level Card -->
                <div class="card bg-white p-6 rounded shadow mb-6">
                    <div class="level-info flex justify-between items-center mb-4">
                        <div>
                            <div class="text-sm text-gray-500 uppercase tracking-wide font-semibold">Aktuelles Level</div>
                            <div class="text-4xl font-bold text-gray-800">{{ $currentLevel }}</div>
                        </div>
                        <div class="flex items-center justify-center w-16 h-16 bg-yellow-50 rounded-full shadow-md border border-yellow-200">
                            <i class="fa-solid fa-trophy text-3xl drop-shadow-sm" style="color: #FFD700;"></i>
                        </div>
                    </div>
                    
                    <div class="progress-container">
                        <div class="progress-labels flex justify-between mb-1 text-sm">
                            <span>Fortschritt zu Level {{ $nextLevel ? ($currentLevel + 1) : 'MAX' }}</span>
                            <span>
                                @if($nextLevel)
                                    {{ $approvedCount - $levels[$currentLevel]['required'] }}/{{ $nextLevel['required'] - $levels[$currentLevel]['required'] }} Empfehlungen
                                @else
                                    Max
                                @endif
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="h-2.5 rounded-full" style="width: {{ $progress }}%; background-color: #6CB4EE;"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            @if($nextLevel)
                                Noch {{ $nextLevel['required'] - $approvedCount }} genehmigte Empfehlung(en) bis Level {{ $currentLevel + 1 }}
                            @else
                                Maximales Level erreicht!
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Total Voucher Card -->
                <div class="card bg-white p-6 rounded shadow mb-6 text-center">
                    <div>
                        <div class="text-gray-500 text-sm">Gesamte Gutscheine verdient</div>
                        <div class="text-4xl font-bold mt-2" style="color: #6cb4ee;">{{ $earnedTotal }}€</div>
                    </div>
                </div>

                <!-- Level Overview -->
                <div>
                    <h3 class="text-lg font-bold text-center mb-4">Level-Übersicht</h3>
                    <div class="level-timeline space-y-4">
                        @foreach($levels as $level)
                            @php
                                $isActive = $level['level'] === $currentLevel;
                                $isPassed = $level['level'] < $currentLevel;
                                $isOpen = $isActive || $isPassed;
                                $chestImage = $isOpen ? asset('assets/offene_truhe.png') : asset('assets/geschlossene_truhe.jpeg');
                                $statusClass = $isOpen ? 'border-green-500 bg-green-50' : 'border-gray-200 bg-white';
                                if ($isActive) $statusClass = 'border-blue-500 bg-green-50 shadow-md'; 
                                
                                // Offene Truhe etwas größer skalieren, da sie optisch oft kleiner wirkt
                                $imgScale = $isOpen ? 'scale-125' : 'scale-100';
                            @endphp

                            <div class="level-item relative border rounded-xl p-4 {{ $statusClass }}">
                                <div class="flex justify-between items-center">
                                    <div class="level-left flex gap-4 items-center">
                                        <div class="w-14 h-14 flex-shrink-0 flex items-center justify-center p-1 overflow-visible">
                                            <img src="{{ $chestImage }}" alt="Truhe" class="max-w-full max-h-full object-contain drop-shadow-sm {{ $imgScale }} transition-transform">
                                        </div>
                                        
                                        <div class="level-info-text">
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-bold text-gray-800">Level {{ $level['level'] }}</h4>
                                                @if($isActive)
                                                    <span class="bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full">Aktuell</span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-500">{{ $level['label'] }}</p>
                                        </div>
                                    </div>
                                    <div class="level-right text-right">
                                        <div class="font-bold text-gray-800 {{ $level['value'] > 0 ? 'text-blue-600' : '' }}">{{ $level['reward'] }}</div>
                                        @if($level['value'] > 0)
                                            <div class="text-xs text-gray-500">Gutschein</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Info Section (Kush) -->
                <div class="mt-20 flex flex-col items-center relative pb-8">
                     <!-- Speech Bubble -->
                     <div class="relative w-64 mb-[-40px] ml-32 z-20 transform -rotate-2">
                        <img src="{{ asset('assets/sprechblase.png') }}" alt="Sprechblase" class="w-full drop-shadow-md">
                        <div class="absolute inset-0 flex items-center justify-center p-6 pb-10">
                            <span class="font-bold text-gray-800 text-base text-center leading-tight">Wie verdiene ich Gutscheine?</span>
                        </div>
                     </div>
                    
                    <!-- Kush Bird -->
                     <div class="z-10">
                        <img src="{{ asset('assets/kush.png') }}" alt="Kush" class="w-64 h-auto transform scale-125 origin-bottom drop-shadow-lg">
                     </div>
                </div>

            </div>
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

