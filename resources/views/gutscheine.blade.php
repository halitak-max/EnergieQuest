<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gutscheine & Level') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media (max-width: 767px) {
            .mobile-bird {
                width: 280px !important;
            }
        }
        @media (min-width: 768px) {
            .desktop-tiny-bird {
                width: 288px !important;
            }
        }
    </style>

    <div class="sm:pb-12 overflow-x-hidden">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container" style="max-width: 100%;">

                <!-- Header Stats -->
                <div class="text-center mb-6">
                    <h2 class="text-lg font-bold">Gutscheine & Level</h2>
                </div>

                <!-- Level Card -->
                <div class="card bg-white p-4 rounded-lg shadow-sm mb-4">
                    <div class="level-info flex justify-between items-center mb-3">
                        <div class="flex flex-col items-center">
                            <div class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Aktuelles Level</div>
                            <div class="text-2xl font-bold text-gray-800 mt-1">{{ $currentLevel }}</div>
                        </div>
                        <div class="flex items-center justify-center w-10 h-10 bg-yellow-50 rounded-full shadow-sm border border-yellow-200 flex-shrink-0" style="transform: translateX(-10%);">
                            <i class="fa-solid fa-trophy text-lg drop-shadow-sm" style="color: #FFD700;"></i>
                        </div>
                    </div>
                    
                    <div class="progress-container">
                        <div class="progress-labels flex justify-between mb-1 text-xs">
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
                        <div class="text-[10px] text-gray-400 mt-1">
                            @if($nextLevel)
                                Noch {{ $nextLevel['required'] - $approvedCount }} genehmigte Empfehlung(en) bis Level {{ $currentLevel + 1 }}
                            @else
                                Maximales Level erreicht!
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Total Voucher Card -->
                <div class="card bg-white p-4 rounded-lg shadow-sm mb-4 text-center">
                    <div>
                        <div class="text-gray-500 text-xs">Gesamte Gutscheine verdient</div>
                        <div class="text-2xl font-bold mt-1" style="color: #6cb4ee;">{{ $earnedTotal }}€</div>
                    </div>
                </div>

                <!-- Level Overview -->
                <div class="mt-8">
                    <h3 class="text-lg font-bold text-center mb-6">Level-Übersicht</h3>
                    <div class="level-timeline space-y-3">
                        @foreach($levels as $level)
                            @php
                                $isActive = $level['level'] === $currentLevel;
                                $isPassed = $level['level'] < $currentLevel;
                                $isOpen = $isActive || $isPassed;
                                $chestImage = $isOpen ? asset('assets/offene_truhe.png') : asset('assets/geschlossene_truhe.jpeg');
                                $statusClass = $isOpen ? 'border-green-500 bg-green-50' : 'border-gray-200 bg-white';
                                if ($isActive) $statusClass = 'border-blue-500 bg-green-50 shadow-sm'; 
                                
                                // Offene Truhe deutlich größer skalieren, da das Bild viel kleiner wirkt
                                // Etwas nach rechts verschieben (translate-x), damit sie nicht die linke Kante berührt
                                $imgStyle = $isOpen ? 'transform: scale(1.6) translateX(10%);' : '';
                            @endphp

                            <div class="level-item relative border rounded-lg p-3 {{ $statusClass }}">
                                <div class="flex justify-between items-center">
                                    <div class="level-left flex gap-6 items-center">
                                        <div class="w-10 h-10 flex-shrink-0 flex items-center justify-center p-1 overflow-visible">
                                            <img src="{{ $chestImage }}" alt="Truhe" class="max-w-full max-h-full object-contain drop-shadow-sm transition-transform" style="{{ $imgStyle }}">
                                        </div>
                                        
                                        <div class="level-info-text">
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-bold text-gray-800 text-sm">Level {{ $level['level'] }}</h4>
                                                @if($isActive)
                                                    <span class="text-white text-xs px-2 py-0.5 rounded-full" style="background-color: #6CB4EE;">Aktuell</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-500">{{ $level['label'] }}</p>
                                        </div>
                                    </div>
                                    <div class="level-right text-right">
                                        @if($level['value'] > 0)
                                            <div class="flex items-center gap-2 justify-end">
                                                <span class="font-bold text-sm" style="color: #6CB4EE;">{{ $level['reward'] }}</span>
                                                <span class="font-bold text-sm text-gray-800">Gutschein</span>
                                            </div>
                                        @else
                                            <div class="font-bold text-sm text-gray-800">{{ $level['reward'] }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Info Section (Kush) -->
                <div class="flex flex-col items-center relative pb-12" style="margin-top: 100px;">
                     <!-- Cloud Speech Bubble (CSS/SVG Path) -->
                     <div class="relative w-full z-50">
                        <div class="bg-white p-4 pt-5 pb-8 shadow-sm relative visible w-full" style="border-radius: 50px;">
                            <!-- Cloud Circles for irregular shape -->
                            <div class="absolute -top-3 left-4 w-10 h-10 bg-white rounded-full"></div>
                            <div class="absolute -top-5 left-10 w-14 h-14 bg-white rounded-full"></div>
                            <div class="absolute -top-3 right-8 w-10 h-10 bg-white rounded-full"></div>
                            <div class="absolute -right-3 top-2 w-10 h-10 bg-white rounded-full"></div>
                            <div class="absolute -left-3 top-2 w-8 h-8 bg-white rounded-full"></div>
                            
                            <p class="text-gray-600 text-[10px] text-center leading-relaxed relative z-20 font-normal whitespace-normal">
                                🥳 Jede Empfehlung lohnt sich! 🥳<br>
                                Jeder erfolgreiche Tarifwechsel bringt dir Punkte,<br>
                                mit denen du im Level aufsteigst und neue Gutscheine freischaltest!
                            </p>
                            
                            <!-- Cloud Tail (Thought Bubble Dots) -->
                        </div>
                     </div>
                    
                    <!-- Kush Bird -->
                     <div class="z-10 mt-2">
                        <img src="{{ asset('assets/kush.png') }}" alt="Kush" class="w-14 h-auto transform scale-100 origin-bottom drop-shadow-md desktop-tiny-bird mobile-bird">
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

