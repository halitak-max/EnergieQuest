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
                            <h1 class="text-3xl font-bold text-gray-800 mb-2">🎯 Ziel des Spiels</h1>
                            <p class="text-xl text-gray-600">EnergieQuest ist ein Empfehlungs- und Belohnungsspiel.</p>
                            <p class="mt-2 text-gray-600">
                                Das Ziel ist es, Energie zu sparen, Freunde einzuladen, Aufgaben zu erfüllen und dadurch Level aufzusteigen sowie Gutscheine zu verdienen.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- 1. Levels -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                    <span class="mr-2">🧩</span> 1. Levels & Fortschritt
                                </h3>
                                <ul class="list-disc list-inside space-y-2 text-gray-700">
                                    <li>Jeder Spieler startet mit <strong>Level 0</strong>.</li>
                                    <li>Um ein Level aufzusteigen, muss eine Empfehlung abgeschlossen werden.</li>
                                    <li>Voraussetzung: Die empfohlene Person lädt ihre Stromrechnung hoch und lässt ihren Stromtarif optimieren.</li>
                                    <li>Der Fortschritt wird im Dashboard angezeigt (Status unter "Empfehlungen").</li>
                                    <li>Höhere Level schalten <strong>höhere Belohnungen</strong> und <strong>zusätzliche Gutscheine</strong> frei.</li>
                                </ul>
                            </div>

                            <!-- 2. Empfehlungen -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                    <span class="mr-2">🧑‍🤝‍🧑</span> 2. Empfehlungen (Referral-System)
                                </h3>
                                <p class="text-gray-700 mb-3">Jeder Spieler erhält einen persönlichen Empfehlungscode.</p>
                                <ul class="list-disc list-inside space-y-2 text-gray-700">
                                    <li>Wird der Code genutzt, entsteht eine <em>pending</em> Empfehlung.</li>
                                    <li>Erfolgreich, wenn:
                                        <ol class="list-decimal list-inside ml-4 mt-1">
                                            <li>Profil erstellt wird</li>
                                            <li>Mindestens eine Quest erfüllt wird (z. B. Upload)</li>
                                        </ol>
                                    </li>
                                    <li>Belohnung: Punkte, Level-Fortschritt, ggf. Gutscheine.</li>
                                </ul>
                            </div>

                            <!-- 3. Upload-Quests -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                    <span class="mr-2">📸</span> 3. Upload-Quests
                                </h3>
                                <p class="text-gray-700 mb-2">Aufgaben, bei denen Fotos/Screenshots eingereicht werden (z. B. Energiespar-Nachweis).</p>
                                <div class="bg-white p-3 rounded border border-gray-200 mt-2">
                                    <h4 class="font-bold text-sm text-gray-700 mb-1">Regeln:</h4>
                                    <ul class="list-disc list-inside text-sm text-gray-600">
                                        <li>Echt, unverändert, selbst angefertigt.</li>
                                        <li>Jeder Upload wird geprüft.</li>
                                        <li>Bringt: Quest-Punkte, Level-Fortschritt, Bonus-Belohnungen.</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- 4. Gutscheine -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                    <span class="mr-2">🎁</span> 4. Gutscheine
                                </h3>
                                <p class="text-gray-700 mb-2">Für Meilensteine erhältst du Gutscheine (Energierabatte, Partnerprämien, Sachgutscheine).</p>
                                <ul class="list-disc list-inside space-y-2 text-gray-700">
                                    <li>Erscheinen im Menüpunkt "Gutscheine".</li>
                                    <li>Jeder Gutschein hat eine Beschreibung, einen Wert und ein Ablaufdatum.</li>
                                </ul>
                            </div>

                            <!-- 5. Profil -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                    <span class="mr-2">👤</span> 5. Profil & Daten
                                </h3>
                                <ul class="list-disc list-inside space-y-2 text-gray-700">
                                    <li>Verwaltung von Name, Adresse, E-Mail.</li>
                                    <li>Einsicht des Empfehlungscodes und Fortschritts.</li>
                                    <li>Daten werden nur für das Spiel und Belohnungen genutzt.</li>
                                </ul>
                            </div>

                            <!-- 6. Belohnungssystem -->
                            <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                    <span class="mr-2">⭐</span> 6. Belohnungssystem
                                </h3>
                                <div class="grid grid-cols-1 gap-2">
                                    <div class="flex items-start">
                                        <span class="font-bold w-32 shrink-0">Punkte:</span>
                                        <span>Für Uploads, Empfehlungen und Quests.</span>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="font-bold w-32 shrink-0">Level:</span>
                                        <span>Kombination aus Aktivitäten.</span>
                                    </div>
                                    <div class="flex items-start">
                                        <span class="font-bold w-32 shrink-0">Gutscheine:</span>
                                        <span>Bei Meilensteinen.</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Regeln -->
                        <div class="mt-8 bg-red-50 p-6 rounded-lg border border-red-100">
                            <h3 class="text-xl font-bold text-red-800 mb-4 flex items-center">
                                <span class="mr-2">⚠️</span> 7. Regeln & Fair Play
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <ul class="list-disc list-inside space-y-1 text-red-700">
                                    <li>Keine Fake-Profile</li>
                                    <li>Keine mehrfachen Registrierungen</li>
                                    <li>Keine künstlichen Uploads/KI-Bilder</li>
                                    <li>Keine Manipulation am Empfehlungssystem</li>
                                </ul>
                                <div class="bg-white p-3 rounded border border-red-100">
                                    <p class="font-bold text-red-800 text-sm">Folgen bei Verstößen:</p>
                                    <p class="text-sm text-red-600">Löschung von Punkten, Kontosperrung, Verlust von Gutscheinen.</p>
                                </div>
                            </div>
                        </div>

                        <!-- 8. Gewinnen -->
                        <div class="mt-8 bg-yellow-50 p-6 rounded-lg border border-yellow-100 text-center">
                            <h3 class="text-xl font-bold text-yellow-800 mb-2 flex justify-center items-center">
                                <span class="mr-2">🏆</span> 8. Wie man gewinnt
                            </h3>
                            <p class="text-yellow-800">
                                Man „gewinnt“ EnergieQuest nicht einmalig — es ist ein laufendes Belohnungssystem.<br>
                                Aktive Spieler erreichen höhere Level, mehr Gutscheine, bessere Badges und Bonus-Quests.
                            </p>
                        </div>
                        
                        <div class="mt-8 text-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
