<x-app-layout>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pb-24 relative z-10">
        <!-- Header -->
        <div class="mb-12 text-center">
            <h1 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 mb-4 flex items-center justify-center gap-3">
                <span class="text-5xl animate-bounce">🎁</span>
                Empfehlungen
                <span class="text-5xl animate-bounce" style="animation-delay: 0.2s;">🎁</span>
            </h1>
            <p class="text-lg text-gray-600 font-medium">Empfehle EnergieQuest weiter und profitiere von attraktiven Prämien</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Erfolgreiche Empfehlungen -->
            <div class="bg-gradient-to-br from-white to-emerald-50 rounded-3xl shadow-lg border-2 border-emerald-100 p-8 hover:shadow-2xl hover:border-emerald-300 transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Erfolgreiche Empfehlungen</h2>
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                        <i class="ri-check-line text-3xl text-white"></i>
                    </div>
                </div>
                <div class="flex items-baseline gap-3">
                    <span class="text-6xl font-black text-gray-900 group-hover:scale-110 transition-transform">{{ $stats['success'] }}</span>
                    <span class="text-base text-gray-600 font-semibold">Angenommen</span>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    @if($stats['this_week_success'] > 0)
                        <div class="flex items-center gap-1 bg-emerald-100 px-3 py-1 rounded-full">
                            <i class="ri-arrow-up-line text-emerald-600 text-sm"></i>
                            <span class="text-xs text-emerald-700 font-bold">+{{ $stats['this_week_success'] }} diese Woche</span>
                        </div>
                        <span class="text-xl animate-bounce">🎉</span>
                    @else
                        <div class="flex items-center gap-1 bg-gray-100 px-3 py-1 rounded-full">
                            <span class="text-xs text-gray-600 font-bold">Keine diese Woche</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Ausstehende Empfehlungen -->
            <div class="bg-gradient-to-br from-white to-amber-50 rounded-3xl shadow-lg border-2 border-amber-100 p-8 hover:shadow-2xl hover:border-amber-300 transition-all duration-300 transform hover:-translate-y-2 group">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Ausstehende Empfehlungen</h2>
                    <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                        <i class="ri-time-line text-3xl text-white"></i>
                    </div>
                </div>
                <div class="flex items-baseline gap-3">
                    <span class="text-6xl font-black text-gray-900 group-hover:scale-110 transition-transform">{{ $stats['pending'] }}</span>
                    <span class="text-base text-gray-600 font-semibold">In Bearbeitung</span>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <div class="flex items-center gap-1 bg-gray-100 px-3 py-1 rounded-full">
                        <span class="text-xs text-gray-600 font-bold">{{ $stats['pending'] > 0 ? 'Ausstehend' : 'Keine ausstehend' }}</span>
                    </div>
                    <span class="text-xl">✨</span>
                </div>
            </div>
        </div>

        <!-- Referral Code Card -->
        <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 rounded-3xl shadow-xl border-2 border-blue-200 p-10 mb-8 hover:shadow-2xl hover:border-blue-400 transition-all duration-300 transform hover:-translate-y-1">
            <div class="max-w-2xl mx-auto">
                <h2 class="text-3xl font-black text-gray-900 mb-3 text-center flex items-center justify-center gap-3">
                    <span class="text-3xl animate-bounce">💎</span>
                    Dein persönlicher Empfehlungscode
                    <span class="text-3xl animate-bounce" style="animation-delay: 0.2s;">💎</span>
                </h2>
                <p class="text-gray-600 text-center mb-8 font-medium">Teile diesen Code mit Freunden und Bekannten</p>
                <div class="bg-white border-3 border-dashed border-blue-400 rounded-2xl p-8 mb-6 hover:border-blue-600 transition-all hover:scale-105 transform shadow-inner relative overflow-hidden group" style="border-width: 3px;">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-blue-100/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity animate-shimmer"></div>
                    <div class="text-center relative z-10 flex items-center justify-center">
                        <span class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 tracking-widest font-mono">{{ Auth::user()->referral_code }}</span>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button onclick="shareReferralCode()" class="w-full bg-gradient-to-r from-blue-500 via-blue-700 to-blue-900 hover:from-blue-600 hover:via-blue-800 hover:to-blue-950 text-white font-bold py-4 px-6 rounded-2xl transition-all duration-300 flex items-center justify-center gap-3 cursor-pointer whitespace-nowrap shadow-xl hover:shadow-2xl transform hover:scale-105 hover:-translate-y-1 group">
                        <i class="ri-share-line text-2xl group-hover:rotate-12 transition-transform"></i>
                        <span class="text-base">Empfehlungscode teilen</span>
                        <span class="text-xl">✨</span>
                    </button>
                        </div>
                    </div>
                </div>

        <!-- My Recommendations Table -->
        <div class="bg-white rounded-3xl shadow-xl border-2 border-blue-100 p-4 sm:p-8 mb-8 hover:shadow-2xl hover:border-blue-300 transition-all duration-300">
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 mb-6 sm:mb-8 flex items-center gap-3">Meine Empfehlungen</h2>
            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <div class="inline-block min-w-full align-middle px-4 sm:px-0">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-blue-100">
                                <th class="text-left py-3 sm:py-5 px-2 sm:px-6 text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wide">Name</th>
                                <th class="text-left py-3 sm:py-5 px-2 sm:px-6 text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wide">Datum</th>
                                <th class="text-left py-3 sm:py-5 px-2 sm:px-6 text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wide">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($referrals as $referral)
                                <tr class="border-b border-blue-50 hover:bg-blue-50/50 transition-all duration-200 group">
                                    <td class="py-3 sm:py-5 px-2 sm:px-6">
                                        <span class="text-sm sm:text-base font-bold text-gray-900">{{ $referral->referredUser->name ?? $referral->referredUser->full_name ?? 'Unbekannt' }}</span>
                                    </td>
                                    <td class="py-3 sm:py-5 px-2 sm:px-6">
                                        <span class="text-xs sm:text-sm text-gray-600 font-medium whitespace-nowrap">{{ $referral->created_at->format('d.m.Y') }}</span>
                                        </td>
                                    <td class="py-3 sm:py-5 px-2 sm:px-6">
                                            @if($referral->status == 0)
                                            <span class="inline-flex items-center gap-1 sm:gap-2 bg-gradient-to-r from-yellow-50 to-amber-50 text-yellow-700 px-2 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm font-bold border-2 border-yellow-200 shadow-sm hover:shadow-md transition-all hover:scale-105 whitespace-nowrap">
                                                <i class="ri-time-line text-sm sm:text-lg"></i>Registriert
                                            </span>
                                            @elseif($referral->status == 1)
                                            <span class="inline-flex items-center gap-1 sm:gap-2 bg-gradient-to-r from-purple-50 to-indigo-50 text-purple-700 px-2 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm font-bold border-2 border-purple-200 shadow-sm hover:shadow-md transition-all hover:scale-105 whitespace-nowrap" style="color: #7e22ce; background: linear-gradient(to right, #f3e8ff, #e9d5ff); border-color: #c084fc;">
                                                <i class="ri-search-line text-sm sm:text-lg"></i>In Prüfung
                                            </span>
                                            @elseif($referral->status == 2)
                                            <span class="inline-flex items-center gap-1 sm:gap-2 bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-700 px-2 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm font-bold border-2 border-emerald-200 shadow-sm hover:shadow-md transition-all hover:scale-105 whitespace-nowrap">
                                                <i class="ri-check-line text-sm sm:text-lg"></i>Genehmigt
                                            </span>
                                            @else
                                            <span class="inline-flex items-center gap-1 sm:gap-2 bg-gradient-to-r from-gray-50 to-slate-50 text-gray-700 px-2 sm:px-4 py-1 sm:py-2 rounded-full text-xs sm:text-sm font-bold border-2 border-gray-200 shadow-sm hover:shadow-md transition-all hover:scale-105 whitespace-nowrap">
                                                <i class="ri-question-line text-sm sm:text-lg"></i>Unbekannt
                                            </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                    <td colspan="3" class="py-8 text-center text-gray-500">
                                        <p class="text-sm">Noch keine Empfehlungen</p>
                                    </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>

        <!-- Benefits Section -->
        <div class="bg-white rounded-3xl shadow-xl border-2 border-blue-100 p-10 hover:shadow-2xl hover:border-blue-300 transition-all duration-300">
            <h2 class="text-3xl font-black text-gray-900 mb-10 text-center flex items-center justify-center gap-3">
                <span class="text-3xl animate-bounce">⭐</span>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Deine Vorteile</span>
                <span class="text-3xl animate-bounce" style="animation-delay: 0.2s;">⭐</span>
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Attraktive Prämien -->
                <div class="text-center p-8 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl border-2 border-blue-200 hover:border-blue-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 group">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                        <i class="ri-gift-line text-4xl text-white"></i>
                    </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Attraktive Prämien</h3>
                <p class="text-sm text-gray-600 font-medium leading-relaxed">Erhalte wertvolle Gutscheine bei erfolgreichem Tarifwechsel deiner Empfehlungen</p>
                </div>

                <!-- Level-System -->
                <div class="text-center p-8 bg-gradient-to-br from-purple-50 to-pink-100 rounded-2xl border-2 border-purple-200 hover:border-purple-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 group">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                        <i class="ri-line-chart-line text-4xl text-white"></i>
                    </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Level-System</h3>
                <p class="text-sm text-gray-600 font-medium leading-relaxed">Steige auf und erhalte bei erfolgreichen Empfehlungen höhere Prämien mit jedem Level</p>
                </div>

                <!-- Gemeinsam sparen -->
                <div class="text-center p-8 bg-gradient-to-br from-orange-50 to-amber-100 rounded-2xl border-2 border-orange-200 hover:border-orange-400 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 group">
                    <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                        <i class="ri-team-line text-4xl text-white"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Gemeinsam sparen</h3>
                    <p class="text-sm text-gray-600 font-medium leading-relaxed">Hilf Freunden beim Energiesparen und profitiert beide</p>
                </div>
            </div>
        </div>

        <!-- Footer Banner -->
        <div class="mt-10 text-center">
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
