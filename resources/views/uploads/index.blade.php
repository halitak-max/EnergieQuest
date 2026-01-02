<x-app-layout>
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
        
        // Berechne Gesamtkosten falls nicht vorhanden
        $currentTotalConsumption = 0;
        $currentTotalBasic = 0;
        $currentTotal = 0;
        if ($user && $user->current_provider) {
            $currentTotalConsumption = ($user->current_consumption ?? 0) * ($user->current_working_price ?? 0) / 100;
            $currentTotalBasic = ($user->current_basic_price ?? 0) * ($user->current_months ?? 12); // Grundpreis für Anzahl Monate
            $currentTotal = $currentTotalConsumption + $currentTotalBasic;
        }
        
        $newTotalConsumption = 0;
        $newTotalBasic = 0;
        $newTotal = 0;
        if ($user && $user->new_provider) {
            $newTotalConsumption = ($user->new_consumption ?? $user->current_consumption ?? 0) * ($user->new_working_price ?? 0) / 100;
            $newTotalBasic = ($user->new_basic_price ?? 0) * ($user->new_months ?? 12); // Grundpreis für Anzahl Monate
            $newTotal = $newTotalConsumption + $newTotalBasic;
        }
        
        // Ersparnisse
        $savingsYear1Eur = $user->savings_year1_eur ?? ($currentTotal - $newTotal);
        $savingsYear1Percent = $user->savings_year1_percent ?? ($currentTotal > 0 ? round((($currentTotal - $newTotal) / $currentTotal) * 100, 1) : 0);
        $savingsYear2Eur = $user->savings_year2_eur ?? $savingsYear1Eur;
        $savingsYear2Percent = $user->savings_year2_percent ?? $savingsYear1Percent;
        $savingsMaxEur = $user->savings_max_eur ?? ($savingsYear1Eur * 2);
        $savingsMaxPercent = $user->savings_max_percent ?? $savingsYear1Percent;
    @endphp

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24 relative z-10">
                @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 text-center" role="alert">
                <span class="block sm:inline font-bold">{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($user && $user->current_provider)
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

            <div id="profile-unlocked-message" class="px-4 py-3 rounded relative mb-6 text-center {{ $showUnlockedMessage && $hasAppointment ? '' : 'hidden' }}" role="alert" style="background-color: #E1FEEA; border: 1px solid #22c55e; color: #166534;">
                    <span class="block sm:inline font-bold">Super. Dein Stromtarif wurde optimiert! Bitte schaue in deine E-Mails dort kannst du ganz einfach den Auftrag unterschreiben und einreichen.</span>
                </div>
            <div id="profile-almost-done-message" class="px-4 py-3 rounded relative mb-6 text-center {{ $showAlmostDoneMessage && !$hasAppointment ? '' : 'hidden' }}" role="alert" style="background-color: #E1FEEA; border: 1px solid #22c55e; color: #166534;">
                    <span class="block sm:inline font-bold">Super. Fast geschafft! Dein Stromtarif wurde optimiert. Schaue Bitte in deine E-mails. Wir benötigen noch deine Unterschrift.</span>
                </div>

            <!-- Angebot Container -->
                <div id="offer-container" style="display: {{ ($showUnlockedMessage || $showAlmostDoneMessage) ? 'none' : 'block' }};">
                <!-- Header -->
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 mb-3 flex items-center justify-center gap-3">
                        <span class="text-5xl animate-bounce">📋</span>
                        Angebot
                        <span class="text-5xl animate-bounce" style="animation-delay: 0.2s;">📋</span>
                    </h1>
                    <p class="text-lg text-gray-600 font-medium flex items-center justify-center gap-2">
                        <span class="text-2xl">😊</span>
                        Dein optimiertes Angebot ist da.
                        <span class="text-2xl">😊</span>
                    </p>
                </div>

                <!-- Comparison Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Aktueller Anbieter -->
                    <div class="bg-gradient-to-br from-red-50 to-pink-50 rounded-3xl shadow-xl p-6 border-2 border-red-200 hover:border-red-300 transition-all duration-300 hover:shadow-2xl transform hover:-translate-y-2">
                        <div class="text-center mb-4">
                            <h2 class="text-lg font-bold text-gray-900 mb-2 flex items-center justify-center gap-2">
                                <span class="text-2xl">📍</span>
                                Ihr aktueller Anbieter
                            </h2>
                                </div>
                        <div class="space-y-3 mb-4">
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">Anbieter Name</p>
                                <p class="text-base font-bold text-gray-900">{{ $user->current_provider ?? 'EON' }}</p>
                                </div>
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">Tarif</p>
                                <p class="text-base font-bold text-gray-900">{{ $user->current_tariff ?? 'Öko' }}</p>
                                </div>
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">PLZ/Ort</p>
                                <p class="text-base font-bold text-gray-900">{{ $user->current_location ?? '4555' }}</p>
                                </div>
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">Verbrauch/Jahr (kWh)</p>
                                <p class="text-base font-bold text-gray-900">{{ number_format($user->current_consumption ?? 12222, 0, ',', '.') }}</p>
                                </div>
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">Anzahl Monate</p>
                                <p class="text-base font-bold text-gray-900">{{ $user->current_months ?? 5 }}</p>
                                </div>
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">Arbeitspreis (Ct./kWh)</p>
                                <p class="text-base font-bold text-gray-900">{{ number_format($user->current_working_price ?? 15.00, 2, ',', '.') }}</p>
                                </div>
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">Grundpreis/Monat (EUR)</p>
                                <p class="text-base font-bold text-gray-900">{{ number_format($user->current_basic_price ?? 20.00, 2, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-red-100 to-pink-100 rounded-2xl p-4 border-2 border-red-300">
                            <p class="text-xs text-gray-600 mb-1">Gesamtkosten EUR (Verbrauch):</p>
                            <p class="text-sm font-bold text-gray-900 mb-2">{{ number_format($currentTotalConsumption, 2, ',', '.') }}</p>
                            <p class="text-xs text-gray-600 mb-1">Grundpreis/Jahr EUR</p>
                            <p class="text-sm font-bold text-gray-900 mb-2">{{ number_format($currentTotalBasic, 2, ',', '.') }}</p>
                            <p class="text-xs text-gray-600 mb-1">Gesamtkosten EUR:</p>
                            <p class="text-2xl font-black text-red-600">{{ number_format($user->current_total ?? $currentTotal, 2, ',', '.') }}</p>
                                </div>
                                </div>

                    <!-- Neuer Anbieter -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-3xl shadow-xl p-6 border-2 border-green-300 hover:border-green-400 transition-all duration-300 hover:shadow-2xl transform hover:-translate-y-2">
                        <div class="text-center mb-4">
                            <h2 class="text-lg font-bold text-gray-900 mb-2 flex items-center justify-center gap-2">
                                <span class="text-2xl">✨</span>
                                Ihr neuer Anbieter
                            </h2>
                                </div>
                        <div class="space-y-3 mb-4">
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">Anbieter Name</p>
                                <p class="text-base font-bold text-gray-900">{{ $user->new_provider ?? 'POWERSTROM' }}</p>
                                </div>
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">Tarif</p>
                                <p class="text-base font-bold text-gray-900">{{ $user->new_tariff ?? 'Öko' }}</p>
                                </div>
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">PLZ/Ort</p>
                                <p class="text-base font-bold text-gray-900">{{ $user->new_location ?? ($user->current_location ?? '4555') }}</p>
                                </div>
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">Verbrauch/Jahr (kWh)</p>
                                <p class="text-base font-bold text-gray-900">{{ number_format($user->new_consumption ?? $user->current_consumption ?? 12222, 0, ',', '.') }}</p>
                                </div>
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">Anzahl Monate</p>
                                <p class="text-base font-bold text-gray-900">{{ $user->new_months ?? 5 }}</p>
                                        </div>
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">Arbeitspreis (Ct./kWh)</p>
                                <p class="text-base font-bold text-gray-900">{{ number_format($user->new_working_price ?? 11.00, 2, ',', '.') }}</p>
                                        </div>
                            <div class="bg-white/70 rounded-xl p-3">
                                <p class="text-xs text-gray-600 mb-1">Grundpreis/Monat (EUR)</p>
                                <p class="text-base font-bold text-gray-900">{{ number_format($user->new_basic_price ?? 20.00, 2, ',', '.') }}</p>
                            </div>
                        </div>
                        <div class="bg-gradient-to-r from-green-100 to-emerald-100 rounded-2xl p-4 border-2 border-green-300">
                            <p class="text-xs text-gray-600 mb-1">Gesamtkosten EUR (Verbrauch):</p>
                            <p class="text-sm font-bold text-gray-900 mb-2">{{ number_format($newTotalConsumption, 2, ',', '.') }}</p>
                            <p class="text-xs text-gray-600 mb-1">Grundpreis/Jahr EUR</p>
                            <p class="text-sm font-bold text-gray-900 mb-2">{{ number_format($newTotalBasic, 2, ',', '.') }}</p>
                            <p class="text-xs text-gray-600 mb-1">Gesamtkosten EUR:</p>
                            <p class="text-2xl font-black text-green-600">{{ number_format($user->new_total ?? $newTotal, 2, ',', '.') }}</p>
                                    </div>
                                </div>

                    <!-- Ersparnis -->
                    <div class="bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-xl p-6 border-2 border-blue-200 hover:border-blue-300 transition-all duration-300 hover:shadow-2xl">
                        <div class="text-center mb-6">
                            <h2 class="text-lg font-bold text-gray-900 mb-2 flex items-center justify-center gap-2">
                                <span class="text-2xl">💰</span>
                                Ihre Ersparnis
                            </h2>
                                    </div>
                        <div class="space-y-4 mb-6">
                            <div class="bg-gradient-to-r from-red-100 to-pink-100 rounded-2xl p-4 border-2 border-red-300">
                                <p class="text-sm text-gray-700 mb-2 font-semibold">Aktueller Anbieter Gesamtkosten EUR:</p>
                                <p class="text-2xl font-black text-gray-900">{{ number_format($user->current_total ?? $currentTotal, 2, ',', '.') }}</p>
                                    </div>
                            <div class="bg-gradient-to-r from-green-100 to-emerald-100 rounded-2xl p-4 border-2 border-green-300">
                                <p class="text-sm text-gray-700 mb-2 font-semibold">Neuer Anbieter Gesamtkosten EUR:</p>
                                <p class="text-2xl font-black text-gray-900">{{ number_format($user->new_total ?? $newTotal, 2, ',', '.') }}</p>
                                </div>
                            <div class="bg-gradient-to-r from-yellow-100 to-amber-100 rounded-2xl p-6 border-2 border-yellow-300 relative overflow-hidden">
                                <div class="absolute top-0 right-0 text-8xl opacity-10">💰</div>
                                <p class="text-sm text-gray-700 mb-2 font-semibold relative z-10">Ersparnis Jahr 1:</p>
                                <p class="text-xs text-gray-600 mb-1 relative z-10">EUR:</p>
                                <p class="text-3xl font-black text-yellow-700 mb-2 relative z-10">{{ number_format($savingsYear1Eur, 2, ',', '.') }}</p>
                                <p class="text-xs text-gray-600 mb-1 relative z-10">%:</p>
                                <p class="text-2xl font-black text-yellow-700 relative z-10">{{ number_format($savingsYear1Percent, 1, ',', '.') }}%</p>
                                    </div>
                            <div class="bg-gradient-to-r from-orange-100 to-amber-100 rounded-2xl p-6 border-2 border-orange-300 relative overflow-hidden">
                                <div class="absolute top-0 right-0 text-8xl opacity-10">💰</div>
                                <p class="text-sm text-gray-700 mb-2 font-semibold relative z-10">Ersparnis Jahr 2:</p>
                                <p class="text-xs text-gray-600 mb-1 relative z-10">EUR:</p>
                                <p class="text-3xl font-black text-orange-700 mb-2 relative z-10">{{ number_format($savingsYear2Eur, 2, ',', '.') }}</p>
                                <p class="text-xs text-gray-600 mb-1 relative z-10">%:</p>
                                <p class="text-2xl font-black text-orange-700 relative z-10">{{ number_format($savingsYear2Percent, 1, ',', '.') }}%</p>
                                    </div>
                            <div class="bg-gradient-to-r from-blue-100 to-blue-100 rounded-2xl p-6 border-2 border-blue-300 relative overflow-hidden">
                                <div class="absolute top-0 right-0 text-8xl opacity-10">🎉</div>
                                <p class="text-sm text-gray-700 mb-2 font-semibold relative z-10">Maximale Ersparnis:</p>
                                <p class="text-xs text-gray-600 mb-1 relative z-10">EUR:</p>
                                <p class="text-4xl font-black text-blue-700 mb-2 relative z-10">{{ number_format($savingsMaxEur, 2, ',', '.') }}</p>
                                <p class="text-xs text-gray-600 mb-1 relative z-10">%:</p>
                                <p class="text-3xl font-black text-blue-700 relative z-10">{{ number_format($savingsMaxPercent, 1, ',', '.') }}%</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <button onclick="acceptOffer()" class="bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 hover:from-green-600 hover:via-emerald-600 hover:to-teal-600 text-white font-bold py-6 px-8 rounded-3xl transition-all duration-300 flex items-center justify-center space-x-3 cursor-pointer whitespace-nowrap shadow-2xl hover:shadow-3xl transform hover:scale-105 hover:-translate-y-2 group border-2 border-green-600">
                        <span class="text-2xl group-hover:scale-125 transition-transform">✅</span>
                        <span class="text-base">ANGEBOT ANNEHMEN</span>
                    </button>
                    <button onclick="openAppointmentModal()" class="bg-gradient-to-r from-yellow-400 via-amber-400 to-orange-400 hover:from-yellow-500 hover:via-amber-500 hover:to-orange-500 text-gray-900 font-bold py-6 px-8 rounded-3xl transition-all duration-300 flex items-center justify-center space-x-3 cursor-pointer whitespace-nowrap shadow-2xl hover:shadow-3xl transform hover:scale-105 hover:-translate-y-2 group border-2 border-orange-500">
                        <span class="text-2xl group-hover:scale-125 transition-transform">📞</span>
                        <span class="text-base">TELEFONGESPRÄCH VEREINBAREN</span>
                    </button>
                </div>

                <!-- Upload Section -->
                <div class="bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-xl p-8 border-2 border-blue-200 hover:border-blue-300 transition-all duration-300">
                    <h2 class="text-3xl font-black text-gray-900 mb-4 text-center flex items-center justify-center gap-3">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Dateien hochladen</span>
                    </h2>
                    <p class="text-center text-gray-600 mb-8 text-base">Lade deine letzte Strom-Jahresabrechnung hoch! Damit wir für dich das beste Angebot erstellen können.</p>
                    
                    <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        <div class="border-3 border-dashed rounded-3xl p-12 mb-6 transition-all duration-300 cursor-pointer border-blue-300 bg-white hover:border-blue-400 hover:bg-blue-50" onclick="document.getElementById('fileInput').click()" style="border-width: 3px;">
                            <div class="text-center">
                                <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl hover:scale-110 transition-transform">
                                    <i class="ri-upload-cloud-2-line text-5xl text-white"></i>
                                </div>
                                <p class="text-xl font-bold text-gray-900 mb-2">Datei auswählen</p>
                                <p class="text-sm text-gray-600 mb-4">Klicken zum Auswählen (Max 10MB)</p>
                            </div>
                            <input id="fileInput" name="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png" type="file" onchange="handleFileSelect(event)">
                        </div>
                        <div id="fileName" class="text-center text-sm text-gray-600 mb-4 hidden"></div>
                        <div class="text-center">
                            <button type="submit" class="bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 hover:from-blue-600 hover:via-indigo-600 hover:to-purple-600 text-white font-bold py-4 px-8 rounded-2xl transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105 hidden" id="uploadButton">
                                Datei hochladen
                            </button>
                        </div>
                    </form>
                    
                    @if($uploads && $uploads->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Hochgeladene Dateien:</h3>
                        <div class="space-y-3">
                            @foreach($uploads as $upload)
                                    <div class="bg-white rounded-xl p-4 flex items-center justify-between border-2 border-gray-200 hover:border-blue-300 transition-all">
                                        <div class="flex items-center space-x-3">
                                            <i class="ri-file-line text-2xl text-blue-500"></i>
                                    <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $upload->original_name }}</p>
                                                <p class="text-xs text-gray-500">{{ $upload->created_at->format('d.m.Y H:i') }}</p>
                                            </div>
                                    </div>
                                        <form action="{{ route('uploads.destroy', $upload) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors">
                                                <i class="ri-delete-bin-line text-xl"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                                </div>
                        </div>
                    @endif
                </div>
            @else
                <!-- No Offer Message -->
                <div class="text-center py-12">
                    <div class="bg-white rounded-3xl shadow-xl p-8 border-2 border-blue-200">
                        <i class="ri-file-search-line text-6xl text-blue-500 mb-4"></i>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Noch kein Angebot verfügbar</h2>
                        <p class="text-gray-600">Bitte lade zuerst deine Jahresabrechnung hoch, damit wir ein Angebot für dich erstellen können.</p>
                </div>
                </div>
            @endif
    </main>

    <!-- Appointment Modal -->
    <div id="appointmentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-6 relative">
            <button onclick="closeAppointmentModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="ri-close-line text-2xl"></i>
                    </button>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Termin vereinbaren</h2>
            <form id="appointmentForm">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Datum auswählen</label>
                    <input type="date" id="appointmentDate" name="appointment_date" class="w-full px-4 py-2 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-blue-500" min="{{ date('Y-m-d') }}" required>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Uhrzeit auswählen</label>
                    <div id="timeSlots" class="grid grid-cols-3 gap-2">
                        <!-- Time slots will be loaded here -->
                    </div>
                    <input type="hidden" id="selectedTime" name="appointment_time">
                    </div>
                <button type="submit" class="w-full bg-gradient-to-r from-yellow-400 via-amber-400 to-orange-400 hover:from-yellow-500 hover:via-amber-500 hover:to-orange-500 text-gray-900 font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Termin buchen
                        </button>
                </form>
        </div>
    </div>

    <script>
        function handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                document.getElementById('fileName').textContent = 'Ausgewählte Datei: ' + file.name;
                document.getElementById('fileName').classList.remove('hidden');
                document.getElementById('uploadButton').classList.remove('hidden');
                }
        }

        function acceptOffer() {
            fetch('{{ route('offer.accept') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                    alert('Angebot erfolgreich angenommen!');
                    location.reload();
                } else {
                    alert(data.message || 'Fehler beim Annehmen des Angebots');
                    if (data.message && data.message.includes('IBAN')) {
                        window.location.href = '{{ route('profile.edit') }}';
                        }
                    }
                })
                .catch(error => {
                console.error('Error:', error);
                alert('Fehler beim Annehmen des Angebots');
            });
        }

        function openAppointmentModal() {
            document.getElementById('appointmentModal').classList.remove('hidden');
            loadAvailableSlots();
        }

        function closeAppointmentModal() {
            document.getElementById('appointmentModal').classList.add('hidden');
        }

        function loadAvailableSlots() {
            const date = document.getElementById('appointmentDate').value;
            if (!date) return;

            fetch(`{{ route('appointment.available-slots') }}?date=${date}`, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const slotsContainer = document.getElementById('timeSlots');
                    slotsContainer.innerHTML = '';
                    
                    data.slots.forEach(slot => {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.textContent = slot.time;
                        button.className = `py-2 px-4 rounded-xl border-2 transition-all ${
                            slot.available 
                                ? 'border-green-300 bg-green-50 text-green-700 hover:bg-green-100 hover:border-green-400' 
                                : 'border-gray-300 bg-gray-100 text-gray-400 cursor-not-allowed'
                        }`;
                        button.disabled = !slot.available;
                        if (slot.available) {
                            button.onclick = () => selectTimeSlot(slot.time);
                        }
                        slotsContainer.appendChild(button);
                    });
                }
            });
        }

        function selectTimeSlot(time) {
            document.querySelectorAll('#timeSlots button').forEach(btn => {
                btn.classList.remove('bg-green-500', 'text-white', 'border-green-600');
            });
            event.target.classList.add('bg-green-500', 'text-white', 'border-green-600');
            document.getElementById('selectedTime').value = time;
        }

        document.getElementById('appointmentDate').addEventListener('change', loadAvailableSlots);

        document.getElementById('appointmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const date = document.getElementById('appointmentDate').value;
            const selectedButton = document.querySelector('#timeSlots button.bg-green-500');
            const time = selectedButton ? selectedButton.textContent : null;
            
            if (!time) {
                alert('Bitte wähle eine Uhrzeit aus');
                return;
            }
            
            fetch('{{ route('appointment.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    appointment_date: date,
                    appointment_time: time
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Termin erfolgreich gebucht!');
                    closeAppointmentModal();
                    location.reload();
                } else {
                    alert(data.message || 'Fehler beim Buchen des Termins');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Fehler beim Buchen des Termins');
            });
        });

        document.getElementById('appointmentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAppointmentModal();
            }
        });
    </script>
</x-app-layout>
