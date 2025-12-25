<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Spielregeln') }}
        </h2>
    </x-slot>

    <div class="sm:pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background-color: #C6DAF1;">
                <div class="p-6 text-gray-900">
                    <div class="prose max-w-none">
                        
                        <!-- Header -->
                        <div class="text-center mb-8">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-800 mb-2 text-center">⚡ EnergieQuest – Dein Spiel. Deine Energie. Deine Belohnungen ⚡</h1>
                        </div>

                        <!-- Willkommens-Container -->
                        <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
                            <p class="text-lg text-gray-700 text-center">Willkommen bei EnergieQuest – dem smarten Empfehlungs- und Belohnungsspiel, bei dem du Energiekosten optimierst, Freunde einlädst und dabei echte Gutscheine freischaltest. Kein Glück, kein Zufall – dein Einsatz entscheidet.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- 1. Dein Ziel -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 text-center whitespace-nowrap overflow-hidden text-ellipsis">
                                    🧠 Dein Ziel 🧠
                                </h3>
                                <p class="text-gray-700 text-center">
                                    Steige im Level auf, sammle Punkte, knacke Meilensteine und sichere dir exklusive Gutscheine. Je aktiver du bist, desto größer werden deine Belohnungen.
                                </p>
                            </div>

                            <!-- 2. Level-System -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <h3 class="text-base sm:text-xl font-bold text-gray-800 mb-4 text-center">
                                    🧩 Level-System 🧩
                                </h3>
                                <p class="text-gray-700 mb-3 text-center">Du startest bei Level 0. Jede erfolgreiche Empfehlung bringt dich deinem nächsten Level näher.</p>
                                <p class="text-gray-700 mb-2 font-semibold text-center">💥 So steigst du auf:</p>
                                <ul class="list-disc list-inside space-y-2 text-gray-700 text-left mt-3">
                                    <li>Du lädst eine Person mit deinem persönlichen Code ein</li>
                                    <li>Sie registriert sich, lädt anschließend Ihre Stromrechnung hoch.</li>
                                    <li>Ihr Stromtarif wird optimiert</li>
                                </ul>
                                <p class="text-gray-700 mt-4 text-center">
                                    👉 Dein Fortschritt ist jederzeit im Dashboard unter „Empfehlungen" sichtbar.<br>
                                    👉 Höhere Level = neue Gutscheine
                                </p>
                            </div>

                            <!-- 3. Empfehlungs-Quest -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <h3 class="text-base sm:text-xl font-bold text-gray-800 mb-4 text-center">
                                    🧑‍🤝‍🧑 Empfehlungs-Quest 🧑‍🤝‍🧑
                                </h3>
                                <p class="text-gray-700 mb-3 text-center">Jeder Spieler erhält einen eigenen Empfehlungscode. Wird er genutzt, startet eine Empfehlung. Erfolgreich wird sie, wenn:</p>
                                <ul class="list-disc list-inside space-y-2 text-gray-700 text-left mt-3">
                                    <li>ein Profil erstellt wird</li>
                                    <li>die Empfohlene Person Ihre Stromkosten optimiert.</li>
                                </ul>
                                <p class="text-gray-700 mt-4 text-center">
                                    🎁 Deine Belohnung: Punkte, Level-Fortschritt und – exklusive Gutscheine.
                                </p>
                                <p class="text-gray-700 mt-2 text-center">
                                    📍 Alle Gutscheine findest du im Menüpunkt „Gutscheine" – inklusive Wert
                                </p>
                            </div>

                            <!-- 4. Profil -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <h3 class="text-lg sm:text-xl font-bold text-gray-800 mb-4 text-center">
                                    👤 Dein Profil 👤
                                </h3>
                                <p class="text-gray-700 mb-3 text-center">Verwalte deine Daten (Name, Adresse, E-Mail, Rufnummer, Geburtsdatum, IBAN), sieh deinen Empfehlungscode und checke jederzeit deinen Fortschritt.</p>
                                <p class="text-gray-700 text-center">
                                    <br>🔐 Deine Daten werden ausschließlich für EnergieQuest, Stromtarifoptimierungen und deine Belohnungen genutzt.
                                </p>
                            </div>

                            <!-- 5. Belohnungssystem -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <h3 class="text-base sm:text-xl font-bold text-gray-800 mb-4 text-center">
                                    ⭐ Belohnungssystem ⭐
                                </h3>
                                <div class="space-y-3 text-gray-700 text-center">
                                    <div>
                                        <strong>1 Punkt</strong> → für Upload Strom-Jahresabrechnung → Angebotserstellung durch uns → Tarifoptimierung des Stromvertrages.
                                    </div>
                                    <div>
                                        <strong>Level</strong> → basierend auf deiner Aktivität
                                    </div>
                                    <div>
                                        <strong>Gutscheine</strong> → bei wichtigen Meilensteinen
                                    </div>
                                </div>
                                <p class="text-gray-700 mt-4 text-center">
                                    Alles greift ineinander – je aktiver du bist, desto mehr lohnt es sich.
                                </p>
                            </div>

                            <!-- 6. Fair Play -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <h3 class="text-lg sm:text-xl font-bold text-red-800 mb-4 text-center">
                                    ⚠️ Fair Play ⚠️
                                </h3>
                                <p class="text-gray-700 mb-3 text-center">EnergieQuest lebt von Ehrlichkeit. Nicht erlaubt:</p>
                                <ul class="list-none space-y-2 text-gray-700 text-left mt-3" style="padding-left: 0;">
                                    <li>• Fake-Profile</li>
                                    <li>• Mehrfach-Registrierungen</li>
                                    <li>• KI- oder manipulierte Uploads</li>
                                    <li>• Missbrauch des Empfehlungssystems</li>
                                </ul>
                                <div class="bg-white p-3 rounded border border-red-200 mt-4">
                                    <p class="font-bold text-red-800 text-sm text-center">🚫 Verstöße führen zu Punktabzug, Gutscheinverlust oder Kontosperre. 🚫</p>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Wie man gewinnt -->
                        <div class="mt-8 bg-white p-6 rounded-lg shadow-sm">
                            <h3 class="text-base sm:text-xl font-bold text-gray-800 mb-4 text-center">
                                🏆 Wie man gewinnt 🏆
                            </h3>
                            <p class="text-gray-700 mb-3 text-center">
                                EnergieQuest geht bis Level 7. Es ist ein Empfehlungs- und Belohnungssystem, wo der Spieler in Summe einen Gutscheinwert von insgesamt 315€ gewinnen kann.
                            </p>
                            <p class="text-gray-700 text-center">
                                <br>🔥 Aktive Spieler erreichen: höhere Level mehr Gutscheine.
                            </p>
                        </div>

                        <!-- Abschluss -->
                        <div class="mt-8">
                            <div class="bg-white p-6 rounded-lg shadow-sm" style="background-color: #E1FEEA;">
                                <p class="text-lg text-gray-700 font-semibold text-center">
                                    Bereit für dein nächstes Level? Starte jetzt, senke deine Energiekosten, lade Freunde ein und hilf Ihnen ebenfalls dabei Ihre Energiekosten zu senken – und verwandle deinen Einsatz in echte Belohnungen. ⚡
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-8 text-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" style="background-color: #1A73E8 !important;" onmouseover="this.style.backgroundColor='#1765CC'" onmouseout="this.style.backgroundColor='#1A73E8'">
                                Zurück zum Dashboard
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="h-32 sm:hidden"></div>
        </div>
    </div>
    
    <style>
        @media (max-width: 640px) {
            .min-h-screen {
                padding-bottom: 80px;
            }
        }
    </style>
    
    <!-- Bottom Nav (Mobile) -->
    <nav class="bottom-nav fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 flex justify-around py-2 sm:hidden z-50">
        <a href="{{ route('dashboard') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-house nav-icon text-xl"></i>
            <span class="text-xs mt-1">Home</span>
        </a>
        <a href="{{ route('uploads.index') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('uploads.*') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-bolt nav-icon text-xl"></i>
            <span class="text-xs mt-1">Angebot</span>
        </a>
        <a href="{{ route('empfehlungen') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('empfehlungen') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-user-plus nav-icon text-xl"></i>
            <span class="text-xs mt-1">Empfehlungen</span>
        </a>
        <a href="{{ route('gutscheine') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('gutscheine') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-ticket nav-icon text-xl"></i>
            <span class="text-xs mt-1">Gutscheine</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('profile.edit') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-regular fa-user nav-icon text-xl"></i>
            <span class="text-xs mt-1">Profil</span>
        </a>
    </nav>
</x-app-layout>
