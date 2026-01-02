<x-app-layout>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Gutscheine 🎉</h1>
            <p class="text-lg text-gray-600">Sammle Empfehlungen und schalte tolle Gutscheine frei!</p>
        </div>

        <!-- Progress Card -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8 transform hover:scale-105 transition-all duration-300">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="relative">
                        <img alt="Gutschein" class="w-32 h-32 object-contain animate-bounce" src="{{ asset('assets/Gutscheinkarte.png') }}">
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Fortschritt zu Level {{ $currentLevel < 7 ? $currentLevel + 1 : 'MAX' }}</h2>
                        <p class="text-gray-600 mb-4">
                            @if($currentLevel < 7)
                                @php
                                    $remaining = max(0, $additionalForNextLevel - ($approvedCount - $currentThreshold));
                                @endphp
                                Noch {{ $remaining }} genehmigte Empfehlungen bis Level {{ $currentLevel + 1 }}
                            @else
                                Maximales Level erreicht!
                            @endif
                        </p>
                        <div class="w-64 h-4 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-500" style="width: {{ $progress }}%;"></div>
                        </div>
                    </div>
                </div>
                <div class="text-center bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-2xl p-6 shadow-lg">
                    <div class="text-sm font-semibold mb-2">AKTUELLES LEVEL</div>
                    <div class="text-6xl font-bold mb-2">{{ $currentLevel }}</div>
                    <div class="text-sm">🔥 Weiter so! 🔥</div>
                </div>
            </div>
        </div>

        <!-- Total Earned Banner -->
        <div class="bg-[#4CAF7A] rounded-3xl shadow-xl p-8 mb-8 text-white text-center transform hover:scale-105 transition-all duration-300">
            <div class="text-2xl font-semibold mb-2">Gesamte Gutscheine verdient</div>
            <div class="text-6xl font-bold mb-2">{{ $earnedTotal }}€</div>
            <div class="text-lg">💰 Großartige Leistung! 💰</div>
        </div>

        <!-- Important Notice -->
        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-3xl shadow-lg p-6 mb-8">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <i class="ri-information-line text-3xl text-yellow-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Wichtiger Hinweis zu Gutscheinen</h3>
                    <p class="text-sm text-gray-700 mb-3"><strong>Gutscheine werden nur bei erfolgreichem Tarifwechsel gewährt.</strong></p>
                    <p class="text-sm text-gray-700 mb-3">Ein erfolgreicher Tarifwechsel liegt vor, wenn:</p>
                    <ul class="list-disc pl-6 text-sm text-gray-700 mb-3 space-y-1">
                        <li>Die geworbene Person sich registriert</li>
                        <li>Die Jahresabrechnung hochgeladen wurde</li>
                        <li>Der Energieversorger den Tarifwechsel annimmt</li>
                        <li>Der Vertrag nicht widerrufen wird</li>
                    </ul>
                    <p class="text-sm text-gray-700"><strong>Es besteht kein Anspruch auf Gutscheine, wenn der Energieversorger den Tarifwechsel ablehnt oder der Vertrag widerrufen wird.</strong></p>
                </div>
            </div>
        </div>

        <!-- Level Overview Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Level-Übersicht</h2>
            <p class="text-gray-600">Schalte neue Gutscheine durch Empfehlungen frei</p>
        </div>

        <!-- Level Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @foreach($levels as $level)
                @if($level['level'] == 0) @continue @endif
                @if($level['level'] > 6) @break @endif
                
                @php
                    $isUnlocked = $level['level'] <= $currentLevel;
                    $isCurrent = $level['level'] == $currentLevel;
                    $gradientColors = [
                        1 => ['from-blue-400', 'to-blue-600'],
                        2 => ['from-orange-400', 'to-orange-600'],
                        3 => ['from-purple-400', 'to-purple-600'],
                        4 => ['from-pink-400', 'to-pink-600'],
                        5 => ['from-teal-400', 'to-teal-600'],
                        6 => ['from-indigo-400', 'to-indigo-600'],
                    ];
                    $colors = $gradientColors[$level['level']] ?? ['from-gray-400', 'to-gray-600'];
                @endphp

                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300 {{ !$isUnlocked ? 'opacity-60' : '' }}">
                    <div class="bg-gradient-to-r {{ $colors[0] }} {{ $colors[1] }} p-6 text-white relative">
                        <div class="absolute top-4 right-4 text-4xl animate-bounce">🎁</div>
                        <div class="text-sm font-semibold mb-2">Level {{ $level['level'] }}</div>
                        <div class="text-5xl font-bold mb-2">{{ $level['reward'] }}</div>
                        <div class="text-sm">{{ $level['label'] }}</div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold text-gray-600">Status:</span>
                            @if($isCurrent)
                                <span class="px-4 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-700">Aktuell</span>
                            @elseif($isUnlocked)
                                <span class="px-4 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">Freigeschaltet</span>
                            @else
                                <span class="px-4 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-500">Gesperrt</span>
                            @endif
                        </div>
                        @if($isUnlocked && isset($voucherCodes[$level['level']]))
                            <div>
                                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                    <div class="text-xs text-gray-500 mb-1">Gutscheincode:</div>
                                    <div class="text-lg font-bold text-gray-800 font-mono">{{ $voucherCodes[$level['level']] }}</div>
                                </div>
                                <button onclick="copyVoucherCode('{{ $voucherCodes[$level['level']] }}')" class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg transform hover:scale-105 transition-all duration-300 whitespace-nowrap">
                                    <i class="ri-file-copy-line mr-2"></i>Code kopieren
                                </button>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="ri-lock-line text-4xl text-gray-400 mb-2"></i>
                                <div class="text-sm text-gray-500">{{ $level['label'] }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- How It Works Section -->
        <div class="bg-white rounded-3xl shadow-xl p-8 mb-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 text-center">So funktioniert's 🎯</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="text-5xl mb-4 animate-bounce">👥</div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">1. Empfehlen</h4>
                    <p class="text-gray-600">Teile deinen Empfehlungscode mit Freunden und Familie</p>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="text-5xl mb-4 animate-bounce">✅</div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">2. Genehmigung</h4>
                    <p class="text-gray-600">Warte auf die Genehmigung deiner Empfehlungen</p>
                </div>
                <div class="text-center p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="text-5xl mb-4 animate-bounce">🎁</div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">3. Gutschein erhalten</h4>
                    <p class="text-gray-600">Bei erfolgreichem Tarifwechsel schaltest du neue Level frei und erhältst höhere Gutscheine</p>
                </div>
            </div>
        </div>

        <!-- Call to Action Banner -->
        <div class="bg-gradient-to-r from-blue-500 via-indigo-600 to-purple-600 rounded-3xl shadow-xl p-8 text-white text-center">
            <h3 class="text-3xl font-bold mb-4">Bereit für mehr Gutscheine? 🚀</h3>
            <p class="text-lg mb-6">Teile deinen Empfehlungscode und schalte das nächste Level frei!</p>
            <button onclick="shareReferralCode()" class="bg-white text-indigo-600 px-8 py-4 rounded-xl font-bold text-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 whitespace-nowrap">
                <i class="ri-share-line mr-2"></i>Jetzt empfehlen
            </button>
        </div>
    </main>

    <script>
        function copyVoucherCode(code) {
            navigator.clipboard.writeText(code).then(() => {
                alert('Gutscheincode kopiert: ' + code);
            }).catch(err => {
                // Fallback
                const textarea = document.createElement('textarea');
                textarea.value = code;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                alert('Gutscheincode kopiert: ' + code);
            });
        }

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
