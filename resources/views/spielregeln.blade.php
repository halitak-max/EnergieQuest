<x-app-layout>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24 relative z-10">
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 rounded-3xl shadow-2xl p-8 mb-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-80 h-80 bg-white/10 rounded-full -mr-40 -mt-40 animate-pulse"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-white/10 rounded-full -ml-32 -mb-32 animate-pulse" style="animation-delay: 1s;"></div>
            <div class="relative z-10 text-center">
                <div class="flex items-center justify-center gap-3 mb-4">
                    <span class="text-5xl animate-bounce">💡</span>
                    <h1 class="text-4xl font-black">Hilfe & Support</h1>
                    <span class="text-5xl animate-bounce" style="animation-delay: 0.2s;">🤝</span>
                </div>
                <p class="text-blue-50 text-lg font-medium">Wir sind hier, um dir zu helfen! Finde Antworten auf deine Fragen.</p>
            </div>
        </div>
                        
        <!-- FAQ Section -->
        <div class="mb-8">
                        <div class="text-center mb-8">
                <h2 class="text-3xl font-black text-gray-900 mb-3 flex items-center justify-center gap-3">
                    <span class="text-4xl">❓</span>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Häufig gestellte Fragen</span>
                </h2>
                <p class="text-gray-600 text-base">Hier findest du Antworten auf die wichtigsten Fragen</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                            <i class="ri-question-line text-2xl text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-gray-900 mb-2">Wie funktioniert das Empfehlungsprogramm?</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Teile deinen persönlichen Empfehlungscode mit Freunden und Familie. Wenn sie sich registrieren, ihre Jahresabrechnung hochladen <strong>und ein erfolgreicher Tarifwechsel stattfindet</strong>, steigst du im Level auf und erhältst Gutscheine. <strong>Gutscheine werden nur bei erfolgreichem Tarifwechsel gewährt.</strong></p>
                        </div>
                    </div>
                            </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                            <i class="ri-gift-line text-2xl text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-gray-900 mb-2">Wann erhalte ich meinen Gutschein?</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Sobald deine Empfehlung erfolgreich abgeschlossen ist (Registrierung + Jahresabrechnung hochgeladen <strong>+ erfolgreicher Tarifwechsel</strong>), erhältst du deinen Gutschein automatisch per E-Mail. Dies kann 1-3 Werktage dauern. <strong>Wichtig:</strong> Ein Gutschein wird nur gewährt, wenn der Energieversorger den Tarifwechsel annimmt und der Vertrag nicht widerrufen wird.</p>
                            </div>
                                </div>
                            </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                            <i class="ri-user-add-line text-2xl text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-gray-900 mb-2">Wie viele Empfehlungen kann ich senden?</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Es gibt keine Begrenzung! Je mehr Freunde du einlädst, desto mehr Gutscheine kannst du verdienen. <strong>Wichtig:</strong> Nicht jede Empfehlung führt automatisch zu einem Gutschein. Ein Gutschein wird nur gewährt, wenn die geworbene Person sich registriert, ihre Jahresabrechnung hochlädt <strong>und ein erfolgreicher Tarifwechsel stattfindet</strong>.</p>
                        </div>
                            </div>
                            </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                            <i class="ri-shield-check-line text-2xl text-white"></i>
                                    </div>
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-gray-900 mb-2">Was passiert mit meinen Daten?</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Deine Daten sind bei uns sicher und werden gemäß DSGVO verarbeitet. Wir geben keine Daten an Dritte weiter. Mehr Infos findest du in unserer Datenschutzerklärung.</p>
                                    </div>
                                </div>
                            </div>

                <!-- FAQ 5 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                            <i class="ri-trophy-line text-2xl text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-gray-900 mb-2">Wie kann ich mein Level erhöhen?</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Dein Level steigt automatisch, wenn deine Empfehlungen erfolgreich sind. Für jede erfolgreich abgeschlossene Empfehlung (Registrierung + Jahresabrechnung hochgeladen <strong>+ erfolgreicher Tarifwechsel</strong>) erhältst du Punkte, die dich zum nächsten Level bringen. <strong>Nur bei erfolgreichem Tarifwechsel wird ein Gutschein gewährt und das Level erhöht.</strong></p>
                                </div>
                            </div>
                        </div>

                <!-- FAQ 6 -->
                <div class="bg-white rounded-2xl shadow-lg p-6 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                            <i class="ri-code-line text-2xl text-white"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-base font-bold text-gray-900 mb-2">Kann ich meinen Empfehlungscode ändern?</h3>
                            <p class="text-sm text-gray-600 leading-relaxed">Dein Empfehlungscode ist einzigartig und personalisiert. Er kann nicht geändert werden, um Verwechslungen zu vermeiden und deine Empfehlungen korrekt zuzuordnen.</p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            
        <!-- Nutzerrichtlinien Section -->
        <div class="mb-8">
            <div class="bg-yellow-50 border-2 border-yellow-200 rounded-3xl shadow-lg p-8">
                <div class="flex items-start gap-4 mb-6">
                    <div class="flex-shrink-0">
                        <i class="ri-information-line text-3xl text-yellow-600"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Hinweise zum Teilen deines Empfehlungscodes</h2>
                        <p class="text-sm text-gray-700 mb-4"><strong>Bitte beachte folgende Richtlinien:</strong></p>
                        <ul class="list-disc pl-6 text-sm text-gray-700 mb-4 space-y-2">
                            <li>Teile deinen Code nur mit Personen, die du kennst und die möglicherweise Interesse haben</li>
                            <li>Versende keine unerwünschten Nachrichten (Spam) oder Massen-E-Mails</li>
                            <li>Respektiere die Privatsphäre anderer Personen</li>
                            <li>Verwende keine automatisierten Systeme oder Bots</li>
                            <li>Halte dich an alle geltenden Gesetze, insbesondere das Gesetz gegen den unlauteren Wettbewerb (UWG)</li>
                        </ul>
                        <p class="text-sm text-gray-700 mb-4"><strong>Wichtig:</strong> Du bist selbst verantwortlich für die Art und Weise, wie du deinen Empfehlungscode weitergibst. Unerwünschte Werbung (Spam) ist gesetzlich untersagt und kann zu rechtlichen Konsequenzen führen.</p>
                        <p class="text-sm text-gray-700"><strong>Bei Verstößen:</strong> Wir behalten uns vor, Gutscheine zu verweigern, Accounts zu sperren oder rechtliche Schritte einzuleiten.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kontaktiere uns Section -->
        <div class="mb-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-black text-gray-900 mb-3 flex items-center justify-center gap-3">
                    <span class="text-4xl">📞</span>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Kontaktiere uns</span>
                </h2>
                <p class="text-gray-600 text-base">Wähle deinen bevorzugten Kontaktweg</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- E-Mail Support -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                        <i class="ri-mail-line text-4xl text-white"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">E-Mail Support</h3>
                    <p class="text-sm text-gray-600 mb-3">Schreibe uns eine E-Mail</p>
                    <a href="mailto:info@energiequest.de" class="text-base font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 transition-all">
                        info@energiequest.de
                    </a>
                </div>

                <!-- Telefon Support -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                        <i class="ri-phone-line text-4xl text-white"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Telefon Support</h3>
                    <p class="text-sm text-gray-600 mb-3">Ruf uns an</p>
                    <a href="tel:+491604535192" class="text-base font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 transition-all">
                        +49 160 4535 192
                    </a>
    </div>
    
                <!-- Live Chat -->
                <div class="bg-white rounded-2xl shadow-lg p-8 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                        <i class="ri-chat-3-line text-4xl text-white"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Live Chat</h3>
                    <p class="text-sm text-gray-600 mb-3">Chatte mit uns</p>
                    <p class="text-base font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                        Mo-Fr: 9:00 - 18:00 Uhr
                    </p>
                </div>
            </div>
        </div>

        <!-- Schnellzugriff Section -->
        <div class="mb-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-black text-gray-900 mb-3 flex items-center justify-center gap-3">
                    <span class="text-4xl">🔗</span>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Schnellzugriff</span>
                </h2>
                <p class="text-gray-600 text-base">Direkt zu den wichtigsten Bereichen</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Datenschutzerklärung -->
                <a href="{{ route('datenschutz') }}" class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg p-6 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group cursor-pointer text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                        <i class="ri-shield-line text-3xl text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-2">Datenschutzerklärung</h3>
                    <p class="text-sm text-gray-600">Erfahre, wie wir deine Daten schützen</p>
        </a>

                <!-- Mein Profil -->
                <a href="{{ route('profile.edit') }}" class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg p-6 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group cursor-pointer text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                        <i class="ri-user-line text-3xl text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-2">Mein Profil</h3>
                    <p class="text-sm text-gray-600">Verwalte deine Kontoinformationen</p>
        </a>

                <!-- Meine Empfehlungen -->
                <a href="{{ route('empfehlungen') }}" class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg p-6 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group cursor-pointer text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                        <i class="ri-user-add-line text-3xl text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-2">Meine Empfehlungen</h3>
                    <p class="text-sm text-gray-600">Sieh deine gesendeten Empfehlungen</p>
        </a>

                <!-- Meine Gutscheine -->
                <a href="{{ route('gutscheine') }}" class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg p-6 border-2 border-blue-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group cursor-pointer text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all">
                        <i class="ri-gift-line text-3xl text-white"></i>
                    </div>
                    <h3 class="text-base font-bold text-gray-900 mb-2">Meine Gutscheine</h3>
                    <p class="text-sm text-gray-600">Verwalte deine verdienten Gutscheine</p>
                </a>
            </div>
        </div>

        <!-- Zurück zu Home Button -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 hover:from-blue-600 hover:via-indigo-600 hover:to-purple-600 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 cursor-pointer whitespace-nowrap shadow-xl hover:shadow-2xl transform hover:scale-105 hover:-translate-y-1">
                <i class="ri-arrow-left-line text-xl"></i>
                <span>Zurück zu Home</span>
            </a>
        </div>

        <!-- Speech Bubble -->
        <div class="mt-8 text-center">
            <div class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-100 via-indigo-100 to-purple-100 px-8 py-4 rounded-full border-2 border-blue-200 shadow-lg">
                <span class="text-2xl">💬</span>
                <p class="text-sm font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Hast du noch Fragen? Wir helfen dir gerne weiter!</p>
                <span class="text-2xl">✨</span>
            </div>
        </div>
    </main>
</x-app-layout>
