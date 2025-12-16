<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background-color: #C6DAF1;">
                <div class="p-6 text-gray-900">
                    <div class="container mx-auto px-4 py-8">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <div class="p-6 bg-gray-50 border-b border-gray-200">
                                <h1 class="text-3xl font-bold text-gray-800">Rechtliches</h1>
                                <p class="text-gray-600 mt-2">Datenschutz, AGB und FAQ</p>
                            </div>

                            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Datenschutzerklärung -->
                                <div class="space-y-6">
                                    <div class="flex items-center space-x-2 mb-4">
                                        <i class="fas fa-shield-alt text-blue-600 text-xl"></i>
                                        <h3 class="text-xl font-bold text-gray-800">Datenschutzerklärung</h3>
                                    </div>

                                    <section>
                                        <h4 class="font-semibold text-gray-700 mb-2">1. Verantwortlicher</h4>
                                        <p class="text-gray-600">
                                            Verantwortlich für die Datenverarbeitung:<br>
                                            [Firma / Betreibername]<br>
                                            [Adresse]<br>
                                            [E-Mail]
                                        </p>
                                    </section>

                                    <section>
                                        <h4 class="font-semibold text-gray-700 mb-2">2. Art der verarbeiteten Daten</h4>
                                        <ul class="list-disc list-inside text-gray-600 space-y-1">
                                            <li>Vor- und Nachname, Adresse, Telefon, E-Mail</li>
                                            <li>IBAN, Vertrags- und Zählerdaten</li>
                                            <li>Hochgeladene Dokumente (z.B. Stromrechnungen)</li>
                                            <li>Weiterempfehlungsdaten</li>
                                        </ul>
                                    </section>

                                    <section>
                                        <h4 class="font-semibold text-gray-700 mb-2">3. Zwecke der Verarbeitung</h4>
                                        <ul class="list-disc list-inside text-gray-600 space-y-1">
                                            <li>Tarifoptimierung und Vertragsanalyse</li>
                                            <li>Digitale Unterschrift (rSign)</li>
                                            <li>Kundenkommunikation & Gutscheinverwaltung</li>
                                        </ul>
                                    </section>

                                    <section>
                                        <h4 class="font-semibold text-gray-700 mb-2">4. Weitergabe an Dritte</h4>
                                        <p class="text-gray-600">
                                            Daten werden nur an Energieversorger (zum Wechsel) und rSign (zur Signatur) weitergegeben. Keine Weitergabe an unbeteiligte Dritte.
                                        </p>
                                    </section>

                                    <section>
                                        <h4 class="font-semibold text-gray-700 mb-2">Rechte & Sicherheit</h4>
                                        <p class="text-gray-600">
                                            Sie haben das Recht auf Auskunft, Löschung und Widerruf. Ihre Daten werden verschlüsselt übertragen.
                                        </p>
                                    </section>
                                </div>

                                <!-- AGB -->
                                <div class="space-y-6">
                                    <div class="flex items-center space-x-2 mb-4">
                                        <i class="fas fa-file-contract text-blue-600 text-xl"></i>
                                        <h3 class="text-xl font-bold text-gray-800">AGB</h3>
                                    </div>

                                    <section>
                                        <h4 class="font-semibold text-gray-700 mb-2">Leistungsbeschreibung</h4>
                                        <p class="text-gray-600">
                                            Wir prüfen Energieverträge, optimieren Tarife und wickeln den Wechsel digital ab.
                                        </p>
                                    </section>

                                    <section>
                                        <h4 class="font-semibold text-gray-700 mb-2">Kosten</h4>
                                        <p class="text-gray-600">
                                            Der Service ist für den Kunden <strong>kostenlos</strong>. Wir erhalten Provisionen von Versorgern.
                                        </p>
                                    </section>

                                    <section>
                                        <h4 class="font-semibold text-gray-700 mb-2">Widerrufsrecht</h4>
                                        <p class="text-gray-600">
                                            Da der Service digital und sofort erbracht wird, entfällt das Widerrufsrecht bei ausdrücklicher Zustimmung.
                                        </p>
                                    </section>

                                    <section>
                                        <h4 class="font-semibold text-gray-700 mb-2">Haftung</h4>
                                        <p class="text-gray-600">
                                            Wir haften nicht für Vertragsablehnungen durch Versorger oder Preisänderungen.
                                        </p>
                                    </section>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 border-t border-gray-200">
                                <!-- FAQ -->
                                <div class="mb-8">
                                    <div class="flex items-center space-x-2 mb-6">
                                        <i class="fas fa-question-circle text-blue-600 text-xl"></i>
                                        <h3 class="text-xl font-bold text-gray-800">Häufige Fragen (FAQ)</h3>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="bg-white p-4 rounded shadow-sm">
                                            <h5 class="font-bold text-gray-800 mb-2">Wie funktioniert die Optimierung?</h5>
                                            <p class="text-gray-600">Sie laden Ihre Rechnung hoch, wir analysieren sie und senden Ihnen ein digitales Angebot.</p>
                                        </div>
                                        <div class="bg-white p-4 rounded shadow-sm">
                                            <h5 class="font-bold text-gray-800 mb-2">Ist der Service kostenlos?</h5>
                                            <p class="text-gray-600">Ja. Wir finanzieren uns durch Provisionen der Energieversorger.</p>
                                        </div>
                                        <div class="bg-white p-4 rounded shadow-sm">
                                            <h5 class="font-bold text-gray-800 mb-2">Wie unterschreibe ich?</h5>
                                            <p class="text-gray-600">Sie erhalten einen Link per SMS/E-Mail und unterschreiben sicher digital über rSign.</p>
                                        </div>
                                        <div class="bg-white p-4 rounded shadow-sm">
                                            <h5 class="font-bold text-gray-800 mb-2">Was passiert mit meinen Daten?</h5>
                                            <p class="text-gray-600">Ihre Daten werden nur für den Wechsel genutzt und niemals ohne Grund weitergegeben.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Impressum -->
                                <div>
                                    <div class="flex items-center space-x-2 mb-4">
                                        <i class="fas fa-building text-blue-600 text-xl"></i>
                                        <h3 class="text-xl font-bold text-gray-800">Impressum</h3>
                                    </div>
                                    <div class="bg-white p-6 rounded shadow-sm">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600">
                                            <div>
                                                <p><span class="font-bold">Firmenname:</span> [Bitte ergänzen]</p>
                                                <p><span class="font-bold">Vertreten durch:</span> [Bitte ergänzen]</p>
                                                <p><span class="font-bold">Adresse:</span> [Bitte ergänzen]</p>
                                            </div>
                                            <div>
                                                <p><span class="font-bold">Kontakt:</span> [Telefon] | [E-Mail]</p>
                                                <p><span class="font-bold">Register:</span> [Handelsregister/Nummer]</p>
                                                <p><span class="font-bold">USt-ID:</span> [ID]</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

