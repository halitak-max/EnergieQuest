<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Uploads') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @php
        $missingFields = [];
        if ($user && (empty($user->iban) || empty($user->birth_date))) {
            if (empty($user->iban)) {
                $missingFields[] = 'IBAN';
            }
            if (empty($user->birth_date)) {
                $missingFields[] = 'Geburtsdatum';
            }
        }
        $showWarning = !empty($missingFields);
    @endphp

    <div class="sm:pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container" style="max-width: 100%;">

                @if(session('success'))
                    <div class="border px-4 py-3 rounded relative mb-4 text-center" role="alert" style="background-color: #FEE2E2; border-color: #FCA5A5; color: #991B1B;">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                     <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($user && $user->current_provider)
                <!-- Meldung wenn Profil freigeschaltet wurde (Button "Nein" aktiv) -->
                @php
                    $showUnlockedMessage = session()->get('show_offer_unlocked_message_' . $user->id, false);
                    $showAlmostDoneMessage = session()->get('show_offer_almost_done_message_' . $user->id, false);
                    $hasAppointment = $user->appointments()->exists();
                    
                    if ($showUnlockedMessage) {
                        session()->forget('show_offer_unlocked_message_' . $user->id);
                    }
                    if ($showAlmostDoneMessage) {
                        session()->forget('show_offer_almost_done_message_' . $user->id);
                    }
                @endphp
                <div id="profile-unlocked-message" class="px-4 py-3 rounded relative mb-4 text-center {{ $showUnlockedMessage && $hasAppointment ? '' : 'hidden' }}" role="alert" style="background-color: #E1FEEA; border: 1px solid #22c55e; color: #166534;">
                    <span class="block sm:inline font-bold">Super. Dein Stromtarif wurde optimiert! Bitte schaue in deine E-Mails dort kannst du ganz einfach den Auftrag unterschreiben und einreichen.</span>
                </div>
                <div id="profile-almost-done-message" class="px-4 py-3 rounded relative mb-4 text-center {{ $showAlmostDoneMessage && !$hasAppointment ? '' : 'hidden' }}" role="alert" style="background-color: #E1FEEA; border: 1px solid #22c55e; color: #166534;">
                    <span class="block sm:inline font-bold">Super. Fast geschafft! Dein Stromtarif wurde optimiert. Schaue Bitte in deine E-mails. Wir benötigen noch deine Unterschrift.</span>
                </div>
                <!-- Angebot Container (wird versteckt wenn Meldung angezeigt wird) -->
                <div id="offer-container" style="display: {{ ($showUnlockedMessage || $showAlmostDoneMessage) ? 'none' : 'block' }};">
                <div class="mb-4 mt-6 text-center">
                    <h2 class="text-2xl font-bold">Angebot</h2>
                    <p class="mt-2 font-bold">🥳 Dein optimiertes Angebot ist da. 🥳</p>
                </div>
                <!-- EKA Vergleich -->
                <div class="card bg-white p-6 rounded shadow mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Ihr aktueller Anbieter -->
                        <div class="border rounded-lg p-4" style="background-color: #FEE2E2;">
                            <h4 class="font-bold text-sm mb-3">Ihr aktueller Anbieter</h4>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Anbieter Name</label>
                                    <div class="text-xs font-medium">{{ $user->current_provider }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Tarif</label>
                                    <div class="text-xs font-medium">{{ $user->current_tariff }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">PLZ/Ort</label>
                                    <div class="text-xs font-medium">{{ $user->current_location }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Verbrauch/Jahr (kWh)</label>
                                    <div class="text-xs font-medium">{{ number_format($user->current_consumption ?? 0, 0, ',', '.') }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Anzahl Monate</label>
                                    <div class="text-xs font-medium">{{ $user->current_months ?? 12 }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Arbeitspreis (Ct./kWh)</label>
                                    <div class="text-xs font-medium">{{ number_format($user->current_working_price ?? 0, 2, ',', '.') }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Grundpreis/Monat (EUR)</label>
                                    <div class="text-xs font-medium">{{ number_format($user->current_basic_price ?? 0, 2, ',', '.') }}</div>
                                </div>
                                <div class="pt-2 border-t">
                                    <div class="text-xs">
                                        <div class="flex justify-between mb-1">
                                            <span>Gesamtkosten EUR (Verbrauch):</span>
                                            <span>{{ number_format(($user->current_consumption ?? 0) * ($user->current_working_price ?? 0) / 100, 2, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between mb-1">
                                            <span>Grundpreis/Jahr EUR:</span>
                                            <span>{{ number_format(($user->current_basic_price ?? 0) * ($user->current_months ?? 12), 2, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between font-bold">
                                            <span>Gesamtkosten EUR:</span>
                                            <span>{{ number_format($user->current_total ?? 0, 2, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ihr neuer Anbieter -->
                        <div class="border rounded-lg p-4" style="background-color: #D1FAE5;">
                            <h4 class="font-bold text-sm mb-3">Ihr neuer Anbieter</h4>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Anbieter Name</label>
                                    <div class="text-xs font-medium">{{ $user->new_provider }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Tarif</label>
                                    <div class="text-xs font-medium">{{ $user->new_tariff }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">PLZ/Ort</label>
                                    <div class="text-xs font-medium">{{ $user->new_location }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Verbrauch/Jahr (kWh)</label>
                                    <div class="text-xs font-medium">{{ number_format($user->new_consumption ?? 0, 0, ',', '.') }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Anzahl Monate</label>
                                    <div class="text-xs font-medium">{{ $user->new_months ?? 12 }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Arbeitspreis (Ct./kWh)</label>
                                    <div class="text-xs font-medium">{{ number_format($user->new_working_price ?? 0, 2, ',', '.') }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Grundpreis/Monat (EUR)</label>
                                    <div class="text-xs font-medium">{{ number_format($user->new_basic_price ?? 0, 2, ',', '.') }}</div>
                                </div>
                                <div class="pt-2 border-t">
                                    <div class="text-xs">
                                        <div class="flex justify-between mb-1">
                                            <span>Gesamtkosten EUR (Verbrauch):</span>
                                            <span>{{ number_format(($user->new_consumption ?? 0) * ($user->new_working_price ?? 0) / 100, 2, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between mb-1">
                                            <span>Grundpreis/Jahr EUR:</span>
                                            <span>{{ number_format(($user->new_basic_price ?? 0) * ($user->new_months ?? 12), 2, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between font-bold">
                                            <span>Gesamtkosten EUR:</span>
                                            <span>{{ number_format($user->new_total ?? 0, 2, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ihre Ersparnis -->
                        <div class="border rounded-lg p-4" style="background-color: #F9FAFB;">
                            <h4 class="font-bold text-sm mb-3">Ihre Ersparnis</h4>
                            <div class="space-y-3 text-sm">
                                <div class="border-b pb-2">
                                    <div class="flex justify-between mb-1 text-xs">
                                        <span>Aktueller Anbieter Gesamtkosten EUR:</span>
                                        <span class="font-medium">{{ number_format($user->current_total ?? 0, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span>Neuer Anbieter Gesamtkosten EUR:</span>
                                        <span class="font-medium">{{ number_format($user->new_total ?? 0, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs mb-2 font-semibold">Ersparnis Jahr 1:</div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span>EUR:</span>
                                        <span class="font-medium">{{ number_format($user->savings_year1_eur ?? 0, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span>%:</span>
                                        <span class="font-medium">{{ number_format($user->savings_year1_percent ?? 0, 1, ',', '.') }}%</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs mb-2 font-semibold">Ersparnis Jahr 2:</div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span>EUR:</span>
                                        <span class="font-medium">{{ number_format($user->savings_year2_eur ?? 0, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span>%:</span>
                                        <span class="font-medium">{{ number_format($user->savings_year2_percent ?? 0, 1, ',', '.') }}%</span>
                                    </div>
                                </div>
                                <div class="border-t pt-2">
                                    <div class="text-xs mb-2 font-bold">Maximale Ersparnis:</div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span>EUR:</span>
                                        <span class="font-bold">{{ number_format($user->savings_max_eur ?? 0, 2, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-xs">
                                        <span>%:</span>
                                        <span class="font-bold">{{ number_format($user->savings_max_percent ?? 0, 1, ',', '.') }}%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center space-y-4 mb-6">
                    @if($showWarning)
                        <div id="profile-warning-message" class="px-4 py-3 rounded relative mb-4 text-center hidden" role="alert" style="background-color: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B;">
                            <span class="block sm:inline">Bitte fülle die Felder IBAN & Geburtsdatum in deinem Profil aus damit wir den finalen Vertrag für dich vorbereiten können.</span>
                        </div>
                    @endif
                    
                    <div id="accept-offer-btn" class="card p-4 rounded-lg shadow-sm text-center cursor-pointer hover:shadow-md transition" style="background-color: #B8F0C8; border: 2px solid #22C55E;" onclick="handleAcceptOffer()">
                        <div class="text-gray-700 text-base font-bold uppercase">Angebot annehmen</div>
                    </div>
                    <div class="card p-4 rounded-lg shadow-sm text-center cursor-pointer hover:shadow-md transition" style="background-color: #FEF9C3; border: 2px solid #EAB308;" onclick="openAppointmentModal()">
                        <div class="text-gray-700 text-base font-bold uppercase">Telefongespräch vereinbaren</div>
                    </div>
                </div>
                </div>
                <!-- Process Container (wird angezeigt wenn Angebot angenommen) -->
                <div id="process-container" class="text-center mb-6" style="display: none;">
                    <div class="mb-4 flex justify-center items-center">
                        <img src="{{ asset('assets/process2.png') }}" alt="Processing" class="mx-auto" style="max-width: 600px; width: 100%; height: auto; display: block; object-fit: contain;">
                    </div>
                    <div class="px-4 py-3 rounded relative text-center" style="background-color: #E1FEEA; border: 1px solid #22c55e; color: #166534;">
                        <span class="block sm:inline font-bold">Vielen Dank. Unser Team erstellt nun den finalen Auftrag. Innerhalb der nächsten 24 Stunden erhälst du deinen Auftrag per E-Mail 😊</span>
                    </div>
                </div>
                @endif

                <!-- Andere Inhalte (werden versteckt wenn Freischaltungs-Meldung angezeigt wird) -->
                <div id="other-content-container">
                <!-- Welcome -->
                <div class="welcome-section text-center mb-6">
                    <h1 class="text-2xl font-bold">Dateien hochladen</h1>
                    <p>Lade deine letzte Strom-Jahresabrechnung hoch! Damit wir für dich das beste Angebot erstellen können.</p>
                </div>

                @if($uploads->count() > 0 && (!$user || !$user->current_provider))
                    <div class="px-4 py-3 rounded relative mb-4 text-center" role="alert" style="background-color: #E1FEEA; border: 1px solid #22c55e;">
                        <span class="block sm:inline text-gray-700">Vielen Dank für dein Upload! Dein Angebot wird von unserem Team erstellt und wird in kürze hier einsehbar.</span>
                    </div>
                @endif

                <!-- Upload Form -->
                <div class="card bg-white p-6 rounded shadow mb-6">
                    <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        <div class="upload-dropzone border-2 border-dashed border-gray-300 rounded-lg p-10 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-50 transition" onclick="document.getElementById('fileInput').click()">
                            <i class="fa-solid fa-cloud-arrow-up text-4xl text-blue-500 mb-2"></i>
                            <h3 class="font-semibold text-lg">Datei auswählen</h3>
                            <p class="text-gray-500 text-sm mt-1">Klicken zum Auswählen (Max 10MB)</p>
                            <input type="file" name="file" id="fileInput" class="hidden" onchange="document.getElementById('uploadForm').submit()">
                        </div>
                    </form>
                </div>

                <!-- File List -->
                <div class="card bg-white p-6 rounded shadow text-center mb-6">
                    <h3 class="font-bold text-lg mb-4">Meine Uploads</h3>
                    
                    @if($uploads->count() > 0)
                        <div class="space-y-3">
                            @foreach($uploads as $upload)
                                <div class="file-list-item flex justify-between items-center p-3 bg-gray-50 rounded hover:bg-gray-100">
                                    <div>
                                        <div class="font-medium">{{ $upload->original_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $upload->created_at->format('d.m.Y H:i') }}</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ Storage::url($upload->file_path) }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        <form action="{{ route('uploads.destroy', $upload) }}" method="POST" onsubmit="return confirm('Wirklich löschen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                         <p class="text-center text-gray-500 text-sm">Noch keine Dateien hochgeladen.</p>
                    @endif
                </div>

                <!-- Infobox -->
                <div class="card p-6 rounded shadow mb-6 border border-blue-300" style="background-color: #EFF6FF;">
                    <h3 class="font-bold text-lg mb-4 text-center text-black">Hinweis zur Jahresabrechnung</h3>
                    <p class="text-gray-700 mb-3 text-center">
                        Bitte lade die Seiten der Jahresabrechnung hoch, auf denen folgende Angaben enthalten sind:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-700 text-left max-w-2xl mx-auto">
                        <li>Preise</li>
                        <li>Zählernummer</li>
                        <li>Marktlokations-ID (Nummer)</li>
                        <li>Jahresverbrauch</li>
                    </ul>
                    <p class="text-gray-700 mt-4 text-center font-semibold">
                        Nur diese Seiten werden für die Bearbeitung benötigt.
                    </p>
                </div>
                </div>
    
                <div class="h-14 sm:hidden mt-3"></div>
            </div>
        </div>
    </div>

    <!-- Appointment Modal -->
    <div id="appointmentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white" style="border-color: #EAB308;">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Telefongespräch vereinbaren</h3>
                    <button onclick="closeAppointmentModal()" class="text-gray-400 hover:text-gray-600 transition">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
                
                <form id="appointmentForm" onsubmit="submitAppointment(event)">
                    <div class="mb-4">
                        <label for="appointmentDate" class="block text-sm font-medium text-gray-700 mb-2">Datum auswählen</label>
                        <input 
                            type="date" 
                            id="appointmentDate" 
                            name="appointment_date" 
                            required
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 transition"
                            style="background-color: #FEF9C3; border-color: #EAB308; color: #713F12;"
                            onfocus="this.style.borderColor='#EAB308'; this.style.boxShadow='0 0 0 3px rgba(234, 179, 8, 0.2)';"
                            onblur="this.style.boxShadow='none';"
                            onchange="validateDate()"
                        >
                        <p class="text-xs mt-1" style="color: #713F12;">Nur Montag bis Freitag verfügbar</p>
                    </div>
                    
                    <div class="mb-4">
                        <label for="appointmentTime" class="block text-sm font-medium text-gray-700 mb-2">Uhrzeit auswählen</label>
                        <select 
                            id="appointmentTime" 
                            name="appointment_time" 
                            required
                            disabled
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 transition"
                            style="background-color: #F9FAFB; border-color: #D1D5DB; color: #6B7280;"
                            onfocus="if(!this.disabled) { this.style.borderColor='#EAB308'; this.style.boxShadow='0 0 0 3px rgba(234, 179, 8, 0.2)'; this.style.backgroundColor='#FEF9C3'; }"
                            onblur="if(!this.disabled) { this.style.boxShadow='none'; }"
                        >
                            <option value="">Bitte zuerst Datum auswählen</option>
                        </select>
                    </div>
                    
                    <div class="flex justify-end gap-3 mt-6">
                        <button 
                            type="button" 
                            onclick="closeAppointmentModal()" 
                            class="px-4 py-2 rounded text-sm font-medium transition"
                            style="background-color: #E5E7EB; color: #374151;"
                            onmouseover="this.style.backgroundColor='#D1D5DB';"
                            onmouseout="this.style.backgroundColor='#E5E7EB';"
                        >
                            Abbrechen
                        </button>
                        <button 
                            type="submit" 
                            class="px-4 py-2 rounded text-sm font-medium transition text-white"
                            style="background-color: #1A73E8;"
                            onmouseover="this.style.backgroundColor='#1765CC'; this.style.boxShadow='0 2px 4px rgba(26, 115, 232, 0.3)';"
                            onmouseout="this.style.backgroundColor='#1A73E8'; this.style.boxShadow='none';"
                        >
                            Termin buchen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Datepicker Styling - Anpassung an die Seitenfarben */
        #appointmentDate::-webkit-calendar-picker-indicator {
            cursor: pointer;
            filter: invert(0.4);
        }
        
        #appointmentDate::-webkit-calendar-picker-indicator:hover {
            filter: invert(0.2);
        }
        
        /* Für Firefox */
        #appointmentDate {
            color-scheme: light;
        }
        
        /* Button Hover-Effekte */
        #appointmentModal button[type="submit"]:hover {
            box-shadow: 0 2px 4px rgba(234, 179, 8, 0.3);
        }
        
        /* Zeitauswahl aktiviert */
        #appointmentTime:not([disabled]) {
            cursor: pointer;
        }
    </style>

    <x-bottom-nav />

    <script>
        function handleAcceptOffer() {
            @if(isset($showWarning) && $showWarning)
                // Wenn Felder fehlen, zeige die Meldung und setze Flag für Ausrufezeichen
                const warningMessage = document.getElementById('profile-warning-message');
                if (warningMessage) {
                    warningMessage.classList.remove('hidden');
                    warningMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                // Setze Flag in LocalStorage, damit das Ausrufezeichen angezeigt wird
                localStorage.setItem('offerButtonClicked', 'true');
                // Aktualisiere das Ausrufezeichen in der Bottom Nav
                updateProfileWarningIcon();
            @else
                // Wenn alle Felder ausgefüllt sind, verstecke das Angebot und zeige nur Process-Container
                const offerContainer = document.getElementById('offer-container');
                const processContainer = document.getElementById('process-container');
                
                if (offerContainer && processContainer) {
                    // Verstecke das Angebot
                    offerContainer.style.display = 'none';
                    // Zeige den Process-Container
                    processContainer.style.display = 'block';
                    // Scrolle zum Process-Container
                    processContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                
                // Speichere den Status im Backend
                fetch('{{ route("offer.accept") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Speichere den Status in LocalStorage, damit es nach Seitenaktualisierung erhalten bleibt
                        localStorage.setItem('offerAccepted', 'true');
                        // Lade die Seite neu, um den aktuellen Status zu zeigen
                        checkOfferAccepted();
                    }
                })
                .catch(error => {
                    console.error('Error accepting offer:', error);
                });
                
                // Entferne den Flag für die Warnung
                localStorage.removeItem('offerButtonClicked');
                updateProfileWarningIcon();
            @endif
        }
        
        function updateProfileWarningIcon() {
            const warningIcon = document.getElementById('profile-warning-icon');
            const warningMessage = document.getElementById('profile-warning-message');
            const offerButtonClicked = localStorage.getItem('offerButtonClicked') === 'true';
            
            // Prüfe ob wir auf der Angebot-Seite oder Profil-Seite sind
            const isOnOfferPage = window.location.pathname.includes('/uploads') || window.location.pathname.includes('/angebot');
            const isOnProfilePage = window.location.pathname.includes('/profile') || window.location.pathname.includes('/profil');
            
            // Wenn der Benutzer nicht auf der Angebot-Seite oder Profil-Seite ist, entferne den Flag und verstecke alles
            if (!isOnOfferPage && !isOnProfilePage) {
                if (offerButtonClicked) {
                    localStorage.removeItem('offerButtonClicked');
                }
                if (warningIcon) {
                    warningIcon.classList.add('hidden');
                }
                if (warningMessage) {
                    warningMessage.classList.add('hidden');
                }
                return;
            }
            
            @if(isset($showWarning) && $showWarning)
                // Wenn Felder noch leer sind und wir auf der Angebot-Seite sind
                if (warningIcon && offerButtonClicked) {
                    warningIcon.classList.remove('hidden');
                } else if (warningIcon) {
                    warningIcon.classList.add('hidden');
                }
            @else
                // Wenn Felder ausgefüllt sind, verstecke Meldung und Ausrufezeichen
                if (warningIcon) {
                    warningIcon.classList.add('hidden');
                }
                if (warningMessage) {
                    warningMessage.classList.add('hidden');
                }
                // Entferne den Flag
                if (offerButtonClicked) {
                    localStorage.removeItem('offerButtonClicked');
                }
            @endif
        }
        
        // Prüfe beim Laden der Seite, ob das Angebot bereits angenommen wurde
        function checkOfferAccepted() {
            try {
                // Hole den aktuellen Status vom Server
                fetch('{{ route("offer.status") }}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const offerAcceptedDb = data.offer_accepted || false;
                    const offerContainer = document.getElementById('offer-container');
                    const processContainer = document.getElementById('process-container');
                    const profileUnlockedMessage = document.getElementById('profile-unlocked-message');
                    const profileAlmostDoneMessage = document.getElementById('profile-almost-done-message');
                    const otherContentContainer = document.getElementById('other-content-container');
                    
                    if (offerAcceptedDb) {
                        // Wenn offer_accepted = true ist (Angebot wurde angenommen)
                        // Verstecke das Angebot und zeige nur Process-Container
                        if (offerContainer) offerContainer.style.display = 'none';
                        if (processContainer) processContainer.style.display = 'block';
                        if (profileUnlockedMessage) profileUnlockedMessage.classList.add('hidden');
                        if (profileAlmostDoneMessage) profileAlmostDoneMessage.classList.add('hidden');
                        if (otherContentContainer) otherContentContainer.style.display = 'block';
                    } else {
                        // Wenn offer_accepted = false ist (Angebot noch nicht angenommen)
                        // Prüfe ob eine Meldung angezeigt wird
                        const showUnlockedMessage = profileUnlockedMessage && !profileUnlockedMessage.classList.contains('hidden');
                        const showAlmostDoneMessage = profileAlmostDoneMessage && !profileAlmostDoneMessage.classList.contains('hidden');
                        
                        if (showUnlockedMessage || showAlmostDoneMessage) {
                            // Wenn eine Meldung angezeigt wird, verstecke das Angebot
                            if (offerContainer) offerContainer.style.display = 'none';
                        } else {
                            // Wenn keine Meldung, zeige das Angebot (wenn current_provider gesetzt ist)
                            if (offerContainer) offerContainer.style.display = 'block';
                        }
                        if (processContainer) processContainer.style.display = 'none';
                        // Die Meldung wird nur angezeigt, wenn sie vom Server gesetzt wurde (Session-Flag)
                        // Das wird bereits im PHP-Teil gehandhabt
                        if (otherContentContainer) otherContentContainer.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error fetching offer status:', error);
                    // Fallback auf LocalStorage und PHP-Wert
                    @php
                        $offerAcceptedDb = Auth::user()->offer_accepted ?? false;
                    @endphp
                    const offerAcceptedDb = @json($offerAcceptedDb);
                    const offerAccepted = localStorage.getItem('offerAccepted') === 'true';
                    const finalOfferAccepted = offerAcceptedDb || offerAccepted;
                    
                    const offerContainer = document.getElementById('offer-container');
                    const processContainer = document.getElementById('process-container');
                    const profileUnlockedMessage = document.getElementById('profile-unlocked-message');
                    const profileAlmostDoneMessage = document.getElementById('profile-almost-done-message');
                    const otherContentContainer = document.getElementById('other-content-container');
                    
                    if (finalOfferAccepted) {
                        // Wenn offer_accepted = true ist (Angebot wurde angenommen)
                        // Verstecke das Angebot und zeige nur Process-Container
                        if (offerContainer) offerContainer.style.display = 'none';
                        if (processContainer) processContainer.style.display = 'block';
                        if (profileUnlockedMessage) profileUnlockedMessage.classList.add('hidden');
                        if (profileAlmostDoneMessage) profileAlmostDoneMessage.classList.add('hidden');
                        if (otherContentContainer) otherContentContainer.style.display = 'block';
                    } else {
                        // Wenn offer_accepted = false ist (Angebot noch nicht angenommen)
                        // Prüfe ob eine Meldung angezeigt wird
                        const showUnlockedMessage = profileUnlockedMessage && !profileUnlockedMessage.classList.contains('hidden');
                        const showAlmostDoneMessage = profileAlmostDoneMessage && !profileAlmostDoneMessage.classList.contains('hidden');
                        
                        if (showUnlockedMessage || showAlmostDoneMessage) {
                            // Wenn eine Meldung angezeigt wird, verstecke das Angebot
                            if (offerContainer) offerContainer.style.display = 'none';
                        } else {
                            // Wenn keine Meldung, zeige das Angebot (wenn current_provider gesetzt ist)
                            if (offerContainer) offerContainer.style.display = 'block';
                        }
                        if (processContainer) processContainer.style.display = 'none';
                        // Die Meldung wird nur angezeigt, wenn sie vom Server gesetzt wurde (Session-Flag)
                        if (otherContentContainer) otherContentContainer.style.display = 'block';
                    }
                });
            } catch (error) {
                console.error('Error in checkOfferAccepted:', error);
                // Fallback: Zeige das Angebot standardmäßig (wird immer angezeigt wenn current_provider gesetzt ist)
                const offerContainer = document.getElementById('offer-container');
                const processContainer = document.getElementById('process-container');
                if (offerContainer) offerContainer.style.display = 'block';
                if (processContainer) processContainer.style.display = 'none';
            }
        }
        
        // Prüfe beim Laden der Seite, ob das Ausrufezeichen angezeigt werden soll
        document.addEventListener('DOMContentLoaded', function() {
            checkOfferAccepted();
            updateProfileWarningIcon();
            
            // Prüfe regelmäßig, ob sich der Status geändert hat (z.B. nach Admin-Änderung)
            setInterval(function() {
                checkOfferAccepted(); // Prüfe den Status regelmäßig
                updateProfileWarningIcon();
            }, 2000); // Alle 2 Sekunden prüfen
        });
        
        // Event-Listener für Navigation (wenn der Benutzer zu einer anderen Seite navigiert)
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.href) {
                const href = link.href;
                const isOfferLink = href.includes('/uploads') || href.includes('/angebot');
                const isProfileLink = href.includes('/profile') || href.includes('/profil');
                
                // Wenn der Benutzer zu einer anderen Seite navigiert (nicht Angebot oder Profil), entferne den Flag
                if (!isOfferLink && !isProfileLink) {
                    const offerButtonClicked = localStorage.getItem('offerButtonClicked') === 'true';
                    if (offerButtonClicked) {
                        localStorage.removeItem('offerButtonClicked');
                        updateProfileWarningIcon();
                    }
                }
            }
        });
        
        // Event-Listener für Storage-Änderungen (wenn LocalStorage in einem anderen Tab geändert wird)
        window.addEventListener('storage', function(e) {
            if (e.key === 'offerButtonClicked') {
                updateProfileWarningIcon();
            }
        });

        // Appointment Modal Functions
        function openAppointmentModal() {
            document.getElementById('appointmentModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            // Setze minimales Datum auf heute
            const today = new Date().toISOString().split('T')[0];
            const dateInput = document.getElementById('appointmentDate');
            dateInput.setAttribute('min', today);
            // Generiere Zeitslots
            generateTimeSlots();
            
            // Öffne den Kalender sofort
            setTimeout(() => {
                dateInput.focus();
                // Versuche den nativen Datepicker zu öffnen (funktioniert in modernen Browsern)
                if (dateInput.showPicker) {
                    try {
                        dateInput.showPicker();
                    } catch (e) {
                        // Fallback: Einfach fokussieren wenn showPicker nicht unterstützt wird
                        dateInput.click();
                    }
                } else {
                    // Fallback für ältere Browser
                    dateInput.click();
                }
            }, 100);
        }

        function closeAppointmentModal() {
            document.getElementById('appointmentModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            // Reset form
            const form = document.getElementById('appointmentForm');
            form.reset();
            // Reset time select
            const timeSelect = document.getElementById('appointmentTime');
            timeSelect.disabled = true;
            timeSelect.style.backgroundColor = '#F9FAFB';
            timeSelect.style.borderColor = '#D1D5DB';
            timeSelect.style.color = '#6B7280';
            timeSelect.innerHTML = '<option value="">Bitte zuerst Datum auswählen</option>';
        }

        function validateDate() {
            const dateInput = document.getElementById('appointmentDate');
            const timeSelect = document.getElementById('appointmentTime');
            const selectedDate = new Date(dateInput.value);
            const dayOfWeek = selectedDate.getDay(); // 0 = Sonntag, 6 = Samstag
            
            // Prüfe ob Samstag (6) oder Sonntag (0)
            if (dayOfWeek === 0 || dayOfWeek === 6) {
                alert('Bitte wählen Sie nur einen Wochentag (Montag bis Freitag) aus.');
                dateInput.value = '';
                // Deaktiviere Zeitauswahl wenn kein Datum gewählt
                timeSelect.disabled = true;
                timeSelect.style.backgroundColor = '#F9FAFB';
                timeSelect.style.borderColor = '#D1D5DB';
                timeSelect.style.color = '#6B7280';
                timeSelect.innerHTML = '<option value="">Bitte zuerst Datum auswählen</option>';
                return false;
            }
            
            // Generiere Zeitslots für das ausgewählte Datum
            generateTimeSlots();
            // Aktiviere Zeitauswahl und fokussiere sie
            timeSelect.disabled = false;
            timeSelect.style.backgroundColor = '#FEF9C3';
            timeSelect.style.borderColor = '#EAB308';
            timeSelect.style.color = '#713F12';
            setTimeout(() => {
                timeSelect.focus();
            }, 100);
            return true;
        }

        function generateTimeSlots() {
            const timeSelect = document.getElementById('appointmentTime');
            const dateInput = document.getElementById('appointmentDate');
            
            // Leere bestehende Optionen
            timeSelect.innerHTML = '<option value="">Bitte wählen</option>';
            
            // Nur Zeitslots generieren wenn ein Datum ausgewählt wurde
            if (!dateInput.value) {
                timeSelect.disabled = true;
                timeSelect.style.backgroundColor = '#F9FAFB';
                timeSelect.style.borderColor = '#D1D5DB';
                timeSelect.style.color = '#6B7280';
                timeSelect.innerHTML = '<option value="">Bitte zuerst Datum auswählen</option>';
                return;
            }
            
            // Aktiviere Zeitauswahl
            timeSelect.disabled = false;
            timeSelect.style.backgroundColor = '#FEF9C3';
            timeSelect.style.borderColor = '#EAB308';
            timeSelect.style.color = '#713F12';
            
            // Generiere Zeitslots von 09:00 bis 18:00 in 15-Minuten-Schritten
            const startHour = 9;
            const endHour = 18;
            const slots = [];
            
            for (let hour = startHour; hour < endHour; hour++) {
                for (let minute = 0; minute < 60; minute += 15) {
                    const timeString = String(hour).padStart(2, '0') + ':' + String(minute).padStart(2, '0');
                    slots.push(timeString);
                }
            }
            
            // Füge Optionen hinzu
            slots.forEach(time => {
                const option = document.createElement('option');
                option.value = time;
                option.textContent = time;
                timeSelect.appendChild(option);
            });
        }

        function submitAppointment(event) {
            event.preventDefault();
            const form = document.getElementById('appointmentForm');
            const formData = new FormData(form);
            const date = formData.get('appointment_date');
            const time = formData.get('appointment_time');
            
            // Validierung
            const selectedDate = new Date(date);
            const dayOfWeek = selectedDate.getDay();
            
            if (dayOfWeek === 0 || dayOfWeek === 6) {
                alert('Bitte wählen Sie nur einen Wochentag (Montag bis Freitag) aus.');
                return;
            }
            
            // Daten an den Server senden
            fetch('{{ route("appointment.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    appointment_date: date,
                    appointment_time: time
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Termin gebucht für ' + new Date(date).toLocaleDateString('de-DE', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + ' um ' + time + ' Uhr');
                    closeAppointmentModal();
                } else {
                    alert(data.message || 'Fehler beim Buchen des Termins');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Fehler beim Buchen des Termins');
            });
        }

        // Schließe Modal beim Klicken außerhalb
        document.getElementById('appointmentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAppointmentModal();
            }
        });
    </script>
</x-app-layout>
