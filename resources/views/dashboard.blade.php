<x-app-layout>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24 relative z-10">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-500 via-blue-700 to-blue-900 rounded-3xl shadow-2xl p-8 mb-8 text-white relative overflow-hidden transform hover:scale-[1.02] transition-all duration-500">
            <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full -mr-40 -mt-40 animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full -ml-32 -mb-32 animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 right-1/4 w-48 h-48 bg-blue-300/20 rounded-full blur-2xl animate-pulse" style="animation-delay: 0.5s;"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <h1 class="text-4xl font-bold mb-2 animate-fade-in flex items-center gap-3">
                            Hallo, {{ explode(' ', Auth::user()->name)[0] }}!<span class="inline-block animate-bounce text-5xl">👋</span>
                        </h1>
                        <p class="text-blue-50 text-lg font-medium">Willkommen zurück bei EnergieQuest!</p>
                        <p class="text-blue-100 text-sm mt-2 flex items-center gap-2">
                            <span class="inline-block w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>Du machst großartige Fortschritte!
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Level Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-xl p-6 h-full border-2 border-blue-100 hover:border-blue-300 transition-all duration-500 hover:shadow-2xl transform hover:-translate-y-1">
                    <div class="text-center">
                        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center justify-center gap-2">
                            <span class="text-2xl">⭐</span>Aktuelles Level
                        </h2>
                        <div class="flex justify-center mb-4">
                            <div class="relative group">
                                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full blur-xl opacity-50 group-hover:opacity-75 transition-opacity"></div>
                                <div class="relative w-36 h-36 bg-gradient-to-br from-amber-400 via-yellow-500 to-orange-500 rounded-full flex items-center justify-center shadow-2xl transform group-hover:scale-110 transition-all duration-500 group-hover:rotate-12">
                                    <span class="text-5xl font-black text-white drop-shadow-lg">{{ $currentLevel }}</span>
                                </div>
                                <div class="absolute -bottom-2 -right-2 w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg animate-bounce">
                                    <i class="ri-star-fill text-white text-xl"></i>
                                </div>
                                <div class="absolute -top-2 -left-2 w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-600 rounded-full flex items-center justify-center shadow-lg animate-pulse">
                                    <i class="ri-fire-fill text-white text-lg"></i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-3 font-semibold flex items-center justify-center gap-2">
                                <span class="text-lg">🚀</span>Fortschritt zu Level {{ $currentLevel < 7 ? $currentLevel + 1 : 'MAX' }}
                            </p>
                            <div class="w-full bg-gray-200 rounded-full h-4 mb-3 overflow-hidden shadow-inner relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shimmer"></div>
                                <div class="bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 h-4 rounded-full transition-all duration-1000 ease-out relative overflow-hidden" style="width: {{ $progress }}%;">
                                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/40 to-transparent animate-shimmer"></div>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mb-3 font-medium">
                                @if($currentLevel < 7)
                                    @php
                                        $remaining = max(0, $additionalForNextLevel - ($approvedReferrals - $currentThreshold));
                                    @endphp
                                    Noch {{ $remaining }} gesendete Empfehlungen bis Level {{ $currentLevel + 1 }}
                                @else
                                    Maximales Level erreicht!
                                @endif
                            </p>
                            <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-full border-2 border-blue-200 hover:border-blue-400 transition-all hover:scale-105">
                                <span class="text-sm font-bold text-blue-700">
                                    @if($currentLevel < 7)
                                        {{ max(0, $approvedReferrals - $currentThreshold) }}/{{ $additionalForNextLevel }} Empfehlungen
                                    @else
                                        Max Level
                                    @endif
                                </span>
                            </div>
                            <p class="text-xs text-blue-600 mt-3 font-semibold animate-pulse">Du schaffst das! 💪</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Erfolgreiche Empfehlungen -->
                <a href="{{ route('empfehlungen') }}" class="bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-lg p-6 border-2 border-blue-100 hover:border-blue-300 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group cursor-pointer block">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-2 font-semibold flex items-center gap-2">
                                <span class="text-lg">📨</span>Erfolgreiche Empfehlungen
                            </p>
                            <p class="text-5xl font-black text-gray-900 mb-2 group-hover:scale-110 transition-transform">{{ $approvedReferrals }}</p>
                            <div class="flex items-center gap-2">
                                @if($thisWeekApproved > 0)
                                    <div class="flex items-center gap-1 bg-green-100 px-3 py-1 rounded-full">
                                        <i class="ri-arrow-up-line text-green-600 text-sm"></i>
                                        <span class="text-xs text-green-700 font-bold">+{{ $thisWeekApproved }} diese Woche</span>
                                    </div>
                                    <span class="text-xl animate-bounce">🎉</span>
                                @else
                                    <div class="flex items-center gap-1 bg-gray-100 px-3 py-1 rounded-full">
                                        <span class="text-xs text-gray-600 font-bold">Keine diese Woche</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                            <i class="ri-user-add-line text-3xl text-white"></i>
                        </div>
                    </div>
                </a>

                <!-- Ausstehende Empfehlungen -->
                <a href="{{ route('empfehlungen') }}" class="bg-gradient-to-br from-white to-orange-50 rounded-3xl shadow-lg p-6 border-2 border-orange-100 hover:border-orange-300 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group cursor-pointer block">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-2 font-semibold flex items-center gap-2">
                                <span class="text-lg">⏳</span>Ausstehende Empfehlungen
                            </p>
                            <p class="text-5xl font-black text-gray-900 mb-2 group-hover:scale-110 transition-transform">{{ $pendingReferrals }}</p>
                            <div class="flex items-center gap-1 bg-gray-100 px-3 py-1 rounded-full">
                                <span class="text-xs text-gray-600 font-bold">{{ $pendingReferrals > 0 ? 'Ausstehend' : 'Keine ausstehend' }}</span>
                                <span class="text-lg">✨</span>
                            </div>
                        </div>
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all duration-300">
                            <i class="ri-time-line text-3xl text-white"></i>
                        </div>
                    </div>
                </a>

                <!-- Empfehlungscode Card -->
                <div class="sm:col-span-2 bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200 rounded-3xl shadow-lg p-6 border-2 border-blue-200 hover:border-blue-400 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center justify-center gap-2">
                        <span class="text-2xl animate-bounce">🎁</span>
                        <span>Mein Empfehlungscode</span>
                        <span class="text-2xl animate-bounce" style="animation-delay: 0.2s;">🎁</span>
                    </h2>
                    <div class="bg-white border-3 border-dashed border-blue-400 rounded-2xl p-6 mb-4 hover:border-blue-600 transition-all hover:scale-105 transform shadow-inner relative overflow-hidden group">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-blue-100/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity animate-shimmer"></div>
                        <p class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-500 to-blue-900 text-center tracking-widest relative z-10">{{ Auth::user()->referral_code }}</p>
                    </div>
                    <button onclick="shareReferralCode()" class="w-full bg-gradient-to-r from-blue-500 via-blue-700 to-blue-900 hover:from-blue-600 hover:via-blue-800 hover:to-blue-950 text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 flex items-center justify-center space-x-2 cursor-pointer whitespace-nowrap shadow-xl hover:shadow-2xl transform hover:scale-105 hover:-translate-y-1 group">
                        <i class="ri-share-line text-2xl group-hover:rotate-12 transition-transform"></i>
                        <span class="text-base">Empfehlungscode teilen</span>
                        <span class="text-xl">✨</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- So erhältst du Gutscheine Section -->
        <div class="bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-xl p-8 mb-8 border-2 border-blue-100 hover:border-blue-300 transition-all duration-300 hover:shadow-2xl">
            <h2 class="text-3xl font-black text-gray-900 mb-8 text-center flex items-center justify-center gap-3">
                <span class="text-4xl animate-bounce">🎁</span>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">So erhältst du Gutscheine!</span>
                <span class="text-4xl animate-bounce" style="animation-delay: 0.2s;">🎁</span>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl p-6 border-2 border-blue-200 hover:border-blue-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 text-8xl opacity-10 font-black text-blue-600">1</div>
                    <div class="flex items-start relative z-10">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                            <span class="text-white font-black text-2xl">1</span>
                        </div>
                        <div>
                            <p class="text-base text-gray-900 font-bold mb-2 flex items-center gap-2">Empfehlungscode teilen<span class="text-xl">📤</span></p>
                            <p class="text-sm text-gray-700">Lade Freunde & Bekannte ein</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl p-6 border-2 border-indigo-200 hover:border-indigo-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 text-8xl opacity-10 font-black text-indigo-600">2</div>
                    <div class="flex items-start relative z-10">
                        <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                            <span class="text-white font-black text-2xl">2</span>
                        </div>
                        <div>
                            <p class="text-base text-gray-900 font-bold mb-2 flex items-center gap-2">Freunde registrieren sich<span class="text-xl">👥</span></p>
                            <p class="text-sm text-gray-700">Mit deinem persönlichen Code</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl p-6 border-2 border-purple-200 hover:border-purple-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 text-8xl opacity-10 font-black text-purple-600">3</div>
                    <div class="flex items-start relative z-10">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                            <span class="text-white font-black text-2xl">3</span>
                        </div>
                        <div>
                            <p class="text-base text-gray-900 font-bold mb-2 flex items-center gap-2">Jahresabrechnung hochladen<span class="text-xl">📄</span></p>
                            <p class="text-sm text-gray-700">Angebot zur Vertragsoptimierung erhalten</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-br from-pink-100 to-rose-100 rounded-2xl p-6 border-2 border-pink-200 hover:border-pink-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 text-8xl opacity-10 font-black text-pink-600">4</div>
                    <div class="flex items-start relative z-10">
                        <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                            <span class="text-white font-black text-2xl">4</span>
                        </div>
                        <div>
                            <p class="text-base text-gray-900 font-bold mb-2 flex items-center gap-2">Bei erfolgreichem Tarifwechsel belohnt werden<span class="text-xl">🏆</span></p>
                            <p class="text-sm text-gray-700">Gutschein kommt per E-Mail nach erfolgreichem Abschluss!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schnellaktionen Section -->
        <div class="bg-gradient-to-br from-white to-indigo-50 rounded-3xl shadow-xl p-8 border-2 border-indigo-100 hover:border-indigo-300 transition-all duration-300 hover:shadow-2xl">
            <h2 class="text-2xl font-black text-gray-900 mb-8 text-center flex items-center justify-center gap-3">
                <span class="text-3xl">⚡</span>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Schnellaktionen</span>
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <a href="{{ route('empfehlungen') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-blue-50 to-indigo-100 hover:from-blue-100 hover:to-indigo-200 rounded-2xl transition-all duration-300 cursor-pointer border-2 border-blue-200 hover:border-blue-400 hover:shadow-xl group transform hover:-translate-y-2 hover:scale-105">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-125 group-hover:rotate-12 transition-all duration-300 shadow-lg">
                        <i class="ri-user-add-line text-3xl text-white"></i>
                    </div>
                    <span class="text-sm font-bold text-gray-900">Empfehlungen</span>
                    <span class="text-xs text-gray-600 mt-1">Freunde einladen</span>
                </a>
                <a href="{{ route('gutscheine') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-orange-50 to-amber-100 hover:from-orange-100 hover:to-amber-200 rounded-2xl transition-all duration-300 cursor-pointer border-2 border-orange-200 hover:border-orange-400 hover:shadow-xl group transform hover:-translate-y-2 hover:scale-105">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-amber-600 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-125 group-hover:rotate-12 transition-all duration-300 shadow-lg">
                        <i class="ri-gift-line text-3xl text-white"></i>
                    </div>
                    <span class="text-sm font-bold text-gray-900">Gutscheine</span>
                    <span class="text-xs text-gray-600 mt-1">Belohnungen</span>
                </a>
                <a href="{{ route('uploads.index') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-purple-50 to-pink-100 hover:from-purple-100 hover:to-pink-200 rounded-2xl transition-all duration-300 cursor-pointer border-2 border-purple-200 hover:border-purple-400 hover:shadow-xl group transform hover:-translate-y-2 hover:scale-105">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-125 group-hover:rotate-12 transition-all duration-300 shadow-lg">
                        <i class="ri-flashlight-line text-3xl text-white"></i>
                    </div>
                    <span class="text-sm font-bold text-gray-900">Angebot</span>
                    <span class="text-xs text-gray-600 mt-1">Dein Tarif</span>
                </a>
                <a href="{{ route('spielregeln') }}" class="flex flex-col items-center justify-center p-6 bg-gradient-to-br from-gray-50 to-slate-100 hover:from-gray-100 hover:to-slate-200 rounded-2xl transition-all duration-300 cursor-pointer border-2 border-gray-200 hover:border-gray-400 hover:shadow-xl group transform hover:-translate-y-2 hover:scale-105">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-600 to-slate-800 rounded-2xl flex items-center justify-center mb-3 group-hover:scale-125 group-hover:rotate-12 transition-all duration-300 shadow-lg">
                        <i class="ri-information-line text-3xl text-white"></i>
                    </div>
                    <span class="text-sm font-bold text-gray-900">Infos</span>
                    <span class="text-xs text-gray-600 mt-1 text-center">Hilfe & Support</span>
                </a>
            </div>
        </div>

        <!-- Footer Banner -->
        <div class="mt-8 text-center">
            <div class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-100 via-indigo-100 to-purple-100 px-8 py-4 rounded-full border-2 border-blue-200 shadow-lg hover:shadow-xl transition-all hover:scale-105">
                <span class="text-2xl animate-bounce">🌟</span>
                <p class="text-sm font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Bei erfolgreichem Tarifwechsel deiner Empfehlungen erhältst du Gutscheine!</p>
                <span class="text-2xl animate-bounce" style="animation-delay: 0.3s;">🎯</span>
            </div>
        </div>
    </main>


    <style>
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .animate-shimmer {
            animation: shimmer 2s infinite;
        }
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }
    </style>

    <script>
        function shareReferralCode() {
            const code = '{{ Auth::user()->referral_code }}';
            const url = '{{ route('register', ['ref' => Auth::user()->referral_code]) }}';
            const text = `Hallo! Ich nutze EnergieQuest zur Tarifoptimierung. Falls du auch Interesse hast, kannst du meinen Empfehlungscode ${code} bei der Anmeldung nutzen: ${url}\n\nKeine Verpflichtung!`;
            
            if (navigator.share) {
                navigator.share({
                    title: 'EnergieQuest Einladung',
                    text: text,
                    url: url
                }).catch(err => console.log('Error sharing', err));
            } else {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Link kopiert! Bitte teile den Code nur mit Personen, die Interesse haben könnten.');
                }).catch(err => {
                    // Fallback: Select text
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);
                    alert('Link kopiert! Bitte teile den Code nur mit Personen, die Interesse haben könnten.');
                });
            }
        }
    </script>
</x-app-layout>
