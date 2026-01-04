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

                @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 text-center" role="alert">
                <span class="block sm:inline font-bold">{{ session('error') }}</span>
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
                    $showOfferAcceptedMessage = session()->get('show_offer_accepted_message_' . $user->id, false);
                    $showUnlockedMessage = session()->get('show_offer_unlocked_message_' . $user->id, false);
                    $showAlmostDoneMessage = session()->get('show_offer_almost_done_message_' . $user->id, false);
                    $showCompletedMessage = session()->get('show_completed_message_' . $user->id, false);
                    $hasAppointment = $user->appointments()->exists();
                    
                    if ($showOfferAcceptedMessage) {
                        session()->forget('show_offer_accepted_message_' . $user->id);
                    }
                    if ($showUnlockedMessage) {
                        session()->forget('show_offer_unlocked_message_' . $user->id);
                    }
                    if ($showAlmostDoneMessage) {
                        session()->forget('show_offer_almost_done_message_' . $user->id);
                    }
                    if ($showCompletedMessage) {
                        session()->forget('show_completed_message_' . $user->id);
                    }
                @endphp

            <!-- Informationsmeldung nach Annahme des Angebots -->
            <div id="offer-accepted-info-message" class="fixed inset-0 flex items-center justify-center z-40 {{ $showOfferAcceptedMessage ? '' : 'hidden' }}">
                <div class="px-6 py-4 rounded-2xl relative text-center max-w-2xl mx-4" role="alert" style="background: linear-gradient(135deg, #E0F2FE 0%, #BAE6FD 100%); border: 2px solid #0EA5E9; color: #0C4A6E;">
                    <div class="flex items-center justify-center gap-3 mb-2">
                        <i class="ri-mail-send-line text-3xl" style="color: #0EA5E9;"></i>
                        <h3 class="text-xl font-bold">Ihr optimierter Vertrag wird erstellt</h3>
                    </div>
                    <p class="text-base font-semibold">Ihr optimierter Vertrag wird derzeit für Sie erstellt und Ihnen in Kürze per E-Mail zugesendet.</p>
                </div>
            </div>

            <!-- Glückwunsch-Meldung nach Erledigt-Markierung -->
            <div id="completed-info-message" class="fixed inset-0 flex items-center justify-center z-40 {{ $showCompletedMessage ? '' : 'hidden' }}">
                <div class="px-6 py-4 rounded-2xl relative text-center max-w-2xl mx-4" role="alert" style="background: linear-gradient(135deg, #E0F2FE 0%, #BAE6FD 100%); border: 2px solid #0EA5E9; color: #0C4A6E;">
                    <div class="flex items-center justify-center gap-3 mb-2">
                        <i class="ri-checkbox-circle-line text-3xl" style="color: #0EA5E9;"></i>
                        <h3 class="text-xl font-bold">Herzlichen Glückwunsch</h3>
                    </div>
                    <p class="text-base font-semibold">Sie haben Ihren Stromtarif erfolgreich optimiert.</p>
                </div>
            </div>

            <!-- IBAN/Geburtsdatum Warnung -->
            <div id="iban-warning-message" class="px-6 py-5 rounded-2xl relative mb-6 hidden" role="alert" style="background: linear-gradient(135deg, #E0F2FE 0%, #BAE6FD 100%); border: 2px solid #0EA5E9; color: #0C4A6E;">
                <div class="flex items-center justify-center gap-3 mb-3">
                    <i class="ri-alert-line text-3xl" style="color: #0EA5E9;"></i>
                    <h3 class="text-xl font-bold">Bitte vervollständigen Sie Ihr Profil</h3>
                </div>
                <p class="text-base font-semibold mb-4 text-center">Bitte fülle die Felder <strong>IBAN</strong> und <strong>Geburtsdatum</strong> aus, bevor du das Angebot annehmen kannst.</p>
                
                <form id="quick-profile-form" class="max-w-md mx-auto">
                    @csrf
                    <div class="mb-4">
                        <div class="flex items-center gap-2 mb-2">
                            <label for="quick_iban" class="block text-sm font-semibold" style="color: #0C4A6E;">IBAN</label>
                            <button 
                                type="button" 
                                onclick="openIbanInfoModal()"
                                class="inline-flex items-center justify-center w-5 h-5 rounded-full text-xs font-bold transition-colors focus:outline-none focus:ring-2 focus:ring-orange-300"
                                style="background-color: transparent; color: #F97316;"
                                onmouseover="this.style.color='#EA580C'"
                                onmouseout="this.style.color='#F97316'"
                                title="Informationen zur IBAN"
                            >
                                <i class="ri-information-line"></i>
                            </button>
                        </div>
                        <input 
                            type="text" 
                            id="quick_iban" 
                            name="iban" 
                            value="{{ $user->iban ?? '' }}"
                            class="w-full px-4 py-2 rounded-lg border-2 border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none"
                            placeholder="DE89 3704 0044 0532 0130 00"
                            maxlength="34"
                        >
                        <div id="iban-error" class="text-red-600 text-sm mt-1 hidden"></div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-semibold mb-2" style="color: #0C4A6E;">Geburtsdatum</label>
                        <div class="flex gap-2 justify-center">
                            @php
                                $birthDay = $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->day : '';
                                $birthMonth = $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->month : '';
                                $birthYear = $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->year : '';
                            @endphp
                            <select id="quick_birth_day" name="birth_day" class="block w-20 rounded-lg border-2 border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none px-2 py-2">
                                <option value="">Tag</option>
                                @for($day = 1; $day <= 31; $day++)
                                    <option value="{{ $day }}" {{ $birthDay == $day ? 'selected' : '' }}>{{ $day }}</option>
                                @endfor
                            </select>
                            <select id="quick_birth_month" name="birth_month" class="block w-32 rounded-lg border-2 border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none px-2 py-2">
                                <option value="">Monat</option>
                                <option value="1" {{ $birthMonth == 1 ? 'selected' : '' }}>Januar</option>
                                <option value="2" {{ $birthMonth == 2 ? 'selected' : '' }}>Februar</option>
                                <option value="3" {{ $birthMonth == 3 ? 'selected' : '' }}>März</option>
                                <option value="4" {{ $birthMonth == 4 ? 'selected' : '' }}>April</option>
                                <option value="5" {{ $birthMonth == 5 ? 'selected' : '' }}>Mai</option>
                                <option value="6" {{ $birthMonth == 6 ? 'selected' : '' }}>Juni</option>
                                <option value="7" {{ $birthMonth == 7 ? 'selected' : '' }}>Juli</option>
                                <option value="8" {{ $birthMonth == 8 ? 'selected' : '' }}>August</option>
                                <option value="9" {{ $birthMonth == 9 ? 'selected' : '' }}>September</option>
                                <option value="10" {{ $birthMonth == 10 ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ $birthMonth == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ $birthMonth == 12 ? 'selected' : '' }}>Dezember</option>
                            </select>
                            <select id="quick_birth_year" name="birth_year" class="block w-24 rounded-lg border-2 border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none px-2 py-2">
                                <option value="">Jahr</option>
                                @php
                                    $currentYear = date('Y');
                                    $minYear = $currentYear - 100;
                                @endphp
                                @for($year = $currentYear - 13; $year >= $minYear; $year--)
                                    <option value="{{ $year }}" {{ $birthYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        <div id="birthdate-error" class="text-red-600 text-sm mt-1 hidden"></div>
                    </div>
                    
                    <div class="flex items-center justify-center gap-3">
                        <button 
                            type="submit" 
                            id="save-quick-profile-btn"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                        >
                            <i class="ri-save-line text-lg"></i>
                            <span>Speichern</span>
                        </button>
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 text-blue-700 hover:text-blue-900 underline font-semibold transition-colors">
                            <i class="ri-user-settings-line text-lg"></i>
                            <span>Zum Profil</span>
                        </a>
                    </div>
                    <div id="quick-profile-success" class="text-green-600 text-sm mt-3 text-center hidden font-semibold"></div>
                </form>
            </div>

            <div id="profile-unlocked-message" class="px-6 py-4 rounded-2xl relative mb-6 text-center {{ $showUnlockedMessage && $hasAppointment ? '' : 'hidden' }}" role="alert" style="background: linear-gradient(135deg, #E0F2FE 0%, #BAE6FD 100%); border: 2px solid #0EA5E9; color: #0C4A6E;">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <i class="ri-mail-send-line text-3xl" style="color: #0EA5E9;"></i>
                    <h3 class="text-xl font-bold">Dein Stromtarif wurde optimiert!</h3>
                </div>
                <p class="text-base font-semibold mb-1">Bitte schaue in deine E-Mails.</p>
                <p class="text-base font-semibold">Dort kannst du ganz einfach den Auftrag unterschreiben und einreichen.</p>
            </div>
            <div id="profile-almost-done-message" class="fixed inset-0 flex items-center justify-center z-40 {{ $showAlmostDoneMessage && !$hasAppointment ? '' : 'hidden' }}">
                <div class="px-6 py-4 rounded-2xl relative text-center max-w-2xl mx-4" role="alert" style="background: linear-gradient(135deg, #E0F2FE 0%, #BAE6FD 100%); border: 2px solid #0EA5E9; color: #0C4A6E;">
                    <div class="flex items-center justify-center gap-3 mb-2">
                        <i class="ri-mail-send-line text-3xl" style="color: #0EA5E9;"></i>
                        <h3 class="text-xl font-bold">Fast geschafft!</h3>
                    </div>
                    <p class="text-base font-semibold mb-1">Dein Stromtarif wurde optimiert.</p>
                    <p class="text-base font-semibold">Bitte schaue in deine E-Mails. Wir benötigen noch deine Unterschrift.</p>
                </div>
            </div>

            <!-- Angebot Container -->
                <div id="offer-container" style="display: {{ ($showOfferAcceptedMessage || $showUnlockedMessage || $showAlmostDoneMessage || $showCompletedMessage) ? 'none' : 'block' }};">
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
                    @php
                        $hasUpcomingAppointment = false;
                        if ($nextAppointment) {
                            $appointmentDateTime = new \DateTime($nextAppointment->appointment_date->format('Y-m-d') . ' ' . $nextAppointment->appointment_time);
                            $hasUpcomingAppointment = $appointmentDateTime >= new \DateTime();
                        }
                    @endphp
                    <button onclick="openAppointmentModal()" class="bg-gradient-to-r from-yellow-400 via-amber-400 to-orange-400 hover:from-yellow-500 hover:via-amber-500 hover:to-orange-500 text-gray-900 font-bold py-6 px-8 rounded-3xl transition-all duration-300 flex items-center justify-center space-x-3 cursor-pointer whitespace-nowrap shadow-2xl hover:shadow-3xl transform hover:scale-105 hover:-translate-y-2 group border-2 border-orange-500 {{ $hasUpcomingAppointment ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $hasUpcomingAppointment ? 'disabled' : '' }}>
                        <span class="text-2xl group-hover:scale-125 transition-transform">📞</span>
                        <span class="text-base">{{ $hasUpcomingAppointment ? 'TERMIN BEREITS GEBUCHT' : 'TELEFONGESPRÄCH VEREINBAREN' }}</span>
                    </button>
                </div>

                <!-- Appointment Info Container -->
                @if($nextAppointment)
                    @php
                        $appointmentDateTime = new \DateTime($nextAppointment->appointment_date->format('Y-m-d') . ' ' . $nextAppointment->appointment_time);
                        $isPast = $appointmentDateTime < new \DateTime();
                    @endphp
                    @if(!$isPast)
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl shadow-xl p-6 border-2 border-blue-200 mb-8">
                            <div class="flex items-center justify-between flex-wrap gap-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="ri-calendar-check-line text-3xl text-blue-600"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-1">Ihr gebuchter Termin</h3>
                                        <p class="text-gray-700">
                                            <strong>Datum:</strong> {{ $nextAppointment->appointment_date->format('d.m.Y') }}<br>
                                            <strong>Uhrzeit:</strong> {{ $nextAppointment->appointment_time }} Uhr
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-xl font-semibold text-sm">
                                        {{ $nextAppointment->status === 'pending' ? 'Ausstehend' : ucfirst($nextAppointment->status) }}
                                    </span>
                                    <button onclick="rescheduleAppointment({{ $nextAppointment->id }})" class="bg-gradient-to-r from-orange-400 via-amber-400 to-yellow-400 hover:from-orange-500 hover:via-amber-500 hover:to-yellow-500 text-gray-900 font-bold py-2 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center gap-2">
                                        <i class="ri-calendar-edit-line text-lg"></i>
                                        <span>Umbuchen</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                <!-- Upload Section -->
                <div class="bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-xl p-8 border-2 border-blue-200 hover:border-blue-300 transition-all duration-300">
                    <h2 class="text-3xl font-black text-gray-900 mb-4 text-center flex items-center justify-center gap-3">
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Dateien hochladen</span>
                    </h2>
                    @php
                        $uploadCount = $uploads ? $uploads->count() : 0;
                        $maxUploads = 3;
                        $canUpload = $uploadCount < $maxUploads;
                    @endphp
                    <p class="text-center text-gray-600 mb-2 text-base">Lade deine letzte Strom-Jahresabrechnung hoch! Damit wir für dich das beste Angebot erstellen können.</p>
                    <p class="text-center text-sm font-semibold mb-8 {{ $canUpload ? 'text-blue-600' : 'text-red-600' }}">
                        Uploads: {{ $uploadCount }} / {{ $maxUploads }}
                        @if(!$canUpload)
                            <span class="block mt-1">⚠️ Maximum erreicht! Bitte löschen Sie zuerst eine Datei, um eine neue hochzuladen.</span>
                        @endif
                    </p>
                    
                    @if($canUpload)
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
                                <input id="fileInput" name="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png" type="file" onchange="document.getElementById('uploadForm').submit()">
                            </div>
                        </form>
                    @else
                        <div class="border-3 border-dashed rounded-3xl p-12 mb-6 border-gray-300 bg-gray-100 opacity-75" style="border-width: 3px;">
                            <div class="text-center">
                                <div class="w-24 h-24 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <i class="ri-upload-cloud-2-line text-5xl text-white"></i>
                                </div>
                                <p class="text-xl font-bold text-gray-700 mb-2">Upload-Limit erreicht</p>
                                <p class="text-sm text-gray-600 mb-4">Sie haben bereits {{ $maxUploads }} Dateien hochgeladen. Bitte löschen Sie zuerst eine Datei, um eine neue hochzuladen.</p>
                            </div>
                        </div>
                    @endif
                    
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
                <!-- No Offer Message & Upload -->
                <div class="text-center py-12 max-w-4xl mx-auto">
                    
                    @php
                        // Get next upcoming appointment for users without offer too
                        $nextAppointment = Auth::user()->appointments()
                            ->where('appointment_date', '>=', now()->format('Y-m-d'))
                            ->where(function($query) {
                                $query->where('appointment_date', '>', now()->format('Y-m-d'))
                                    ->orWhere(function($q) {
                                        $q->where('appointment_date', '=', now()->format('Y-m-d'))
                                          ->where('appointment_time', '>', now()->format('H:i'));
                                    });
                            })
                            ->orderBy('appointment_date')
                            ->orderBy('appointment_time')
                            ->get()
                            ->first(function ($appointment) {
                                return $appointment->status !== 'cancelled';
                            });
                        
                        $hasUpcomingAppointment = false;
                        if ($nextAppointment) {
                            $appointmentDateTime = new \DateTime($nextAppointment->appointment_date->format('Y-m-d') . ' ' . $nextAppointment->appointment_time);
                            $hasUpcomingAppointment = $appointmentDateTime >= new \DateTime();
                        }
                    @endphp
                    
                    @if($uploads && $uploads->count() > 0)
                        <!-- Separate Erfolgsmeldung Container -->
                        <div class="bg-green-50 rounded-3xl shadow-xl p-8 border-2 border-green-200 mb-8">
                            <div class="flex items-center justify-center gap-4">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="ri-check-line text-3xl text-green-600"></i>
                                </div>
                                <div class="text-left">
                                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Vielen Dank für deine Unterlagen!</h2>
                                    <p class="text-lg text-gray-700">
                                        Wir erstellen dein optimiertes Angebot. <br>
                                        <strong>In der Regel erhältst du dein Ergebnis innerhalb von 24 Stunden hier auf dieser Seite.</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Appointment Info Container (auch ohne Angebot) -->
                    @if($nextAppointment)
                        @php
                            $appointmentDateTime = new \DateTime($nextAppointment->appointment_date->format('Y-m-d') . ' ' . $nextAppointment->appointment_time);
                            $isPast = $appointmentDateTime < new \DateTime();
                        @endphp
                        @if(!$isPast)
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-3xl shadow-xl p-6 border-2 border-blue-200 mb-8">
                                <div class="flex items-center justify-between flex-wrap gap-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <i class="ri-calendar-check-line text-3xl text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900 mb-1">Ihr gebuchter Termin</h3>
                                            <p class="text-gray-700">
                                                <strong>Datum:</strong> {{ $nextAppointment->appointment_date->format('d.m.Y') }}<br>
                                                <strong>Uhrzeit:</strong> {{ $nextAppointment->appointment_time }} Uhr
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-xl font-semibold text-sm">
                                            {{ $nextAppointment->status === 'pending' ? 'Ausstehend' : ucfirst($nextAppointment->status) }}
                                        </span>
                                        <button onclick="rescheduleAppointment({{ $nextAppointment->id }})" class="bg-gradient-to-r from-orange-400 via-amber-400 to-yellow-400 hover:from-orange-500 hover:via-amber-500 hover:to-yellow-500 text-gray-900 font-bold py-2 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center gap-2">
                                            <i class="ri-calendar-edit-line text-lg"></i>
                                            <span>Umbuchen</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                    <!-- Anleitung -->
                    <div class="bg-white rounded-3xl shadow-xl p-8 border-2 border-blue-200 mb-8">
                        <!-- Initiale Anleitung (immer sichtbar) -->
                        <div class="mb-6">
                            @if(!($uploads && $uploads->count() > 0))
                                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="ri-file-search-line text-4xl text-blue-600"></i>
                                </div>
                            @endif
                            
                            <h2 class="text-2xl font-bold text-gray-900 mb-4">So einfach kommst du zu deinem Angebot</h2>
                            <div class="text-left max-w-2xl mx-auto space-y-4 text-gray-600">
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 font-bold">1</div>
                                    <p>Lade deine letzte <strong>Strom-Jahresabrechnung</strong> unten hoch.</p>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 font-bold">2</div>
                                    <div>
                                        <p class="mb-1">Wir analysieren die wichtigen Daten für dich:</p>
                                        <ul class="list-disc list-inside pl-1 text-sm space-y-1 text-gray-500">
                                            <li>Deinen Jahresverbrauch (kWh)</li>
                                            <li>Deine aktuellen Preise (Grund- & Arbeitspreis)</li>
                                            <li>Deinen aktuellen Anbieter</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0 font-bold">3</div>
                                    <p>Innerhalb von <strong>24 Stunden</strong> erhältst du dein optimiertes Angebot direkt hier auf dieser Seite!</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Formular -->
                    <div class="bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-xl p-8 border-2 border-blue-200 hover:border-blue-300 transition-all duration-300">
                        <h2 class="text-3xl font-black text-gray-900 mb-4 text-center flex items-center justify-center gap-3">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">Dateien hochladen</span>
                        </h2>
                        @php
                            $uploadCount = $uploads ? $uploads->count() : 0;
                            $maxUploads = 3;
                            $canUpload = $uploadCount < $maxUploads;
                        @endphp
                        <p class="text-center text-gray-600 mb-2 text-base">Lade deine letzte Strom-Jahresabrechnung hoch!</p>
                        <p class="text-center text-sm font-semibold mb-8 {{ $canUpload ? 'text-blue-600' : 'text-red-600' }}">
                            Uploads: {{ $uploadCount }} / {{ $maxUploads }}
                            @if(!$canUpload)
                                <span class="block mt-1">⚠️ Maximum erreicht! Bitte löschen Sie zuerst eine Datei, um eine neue hochzuladen.</span>
                            @endif
                        </p>
                        
                        @if($canUpload)
                            <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data" id="uploadFormInitial">
                                @csrf
                                <div class="border-3 border-dashed rounded-3xl p-12 mb-6 transition-all duration-300 cursor-pointer border-blue-300 bg-white hover:border-blue-400 hover:bg-blue-50" onclick="document.getElementById('fileInputInitial').click()" style="border-width: 3px;">
                                    <div class="text-center">
                                        <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-xl hover:scale-110 transition-transform">
                                            <i class="ri-upload-cloud-2-line text-5xl text-white"></i>
                                        </div>
                                        <p class="text-xl font-bold text-gray-900 mb-2">Datei auswählen</p>
                                        <p class="text-sm text-gray-600 mb-4">Klicken zum Auswählen (Max 10MB)</p>
                                    </div>
                                    <input id="fileInputInitial" name="file" class="hidden" accept=".pdf,.jpg,.jpeg,.png" type="file" onchange="document.getElementById('uploadFormInitial').submit()">
                                </div>
                            </form>
                        @else
                            <div class="border-3 border-dashed rounded-3xl p-12 mb-6 border-gray-300 bg-gray-100 opacity-75" style="border-width: 3px;">
                                <div class="text-center">
                                    <div class="w-24 h-24 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <i class="ri-upload-cloud-2-line text-5xl text-white"></i>
                                    </div>
                                    <p class="text-xl font-bold text-gray-700 mb-2">Upload-Limit erreicht</p>
                                    <p class="text-sm text-gray-600 mb-4">Sie haben bereits {{ $maxUploads }} Dateien hochgeladen. Bitte löschen Sie zuerst eine Datei, um eine neue hochzuladen.</p>
                                </div>
                            </div>
                        @endif
                        
                        <!-- Liste der bereits hochgeladenen Dateien anzeigen -->
                        @if($uploads && $uploads->count() > 0)
                            <div class="mt-8 text-left">
                                <h3 class="text-xl font-bold text-gray-900 mb-4">Bereits hochgeladen:</h3>
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
                </div>
            @endif
    </main>

    <style>
        /* Styling für disabled Optionen im Select */
        #timeSlotSelect option:disabled {
            color: #9CA3AF !important;
            background-color: #F3F4F6 !important;
            font-style: italic;
        }
    </style>

    <!-- IBAN Info Modal -->
    <div id="ibanInfoModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full p-6 relative">
            <button onclick="closeIbanInfoModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="ri-close-line text-2xl"></i>
            </button>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="ri-information-line text-2xl text-blue-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Informationen zur IBAN</h2>
            </div>
            <div class="space-y-3 text-gray-700">
                <p class="text-base">
                    Die <strong>IBAN-Nummer</strong> wird nur zur <strong>Vertragserfassung</strong> benötigt.
                </p>
                <p class="text-base">
                    Die Eingabe der IBAN stellt <strong>noch keinen finalen Vertragsabschluss</strong> dar.
                </p>
                <p class="text-base text-gray-600 italic">
                    Sie können Ihre IBAN jederzeit in Ihrem Profil ändern oder entfernen.
                </p>
            </div>
            <div class="mt-6 flex justify-end">
                <button 
                    onclick="closeIbanInfoModal()" 
                    class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-2 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl"
                >
                    Verstanden
                </button>
            </div>
        </div>
    </div>

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
                    <select id="timeSlotSelect" class="w-full px-4 py-2 border-2 border-gray-300 rounded-xl focus:outline-none focus:border-blue-500 bg-white" disabled>
                        <option value="">Bitte wählen Sie zuerst ein Datum aus</option>
                    </select>
                    <input type="hidden" id="selectedTime" name="appointment_time">
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-yellow-400 via-amber-400 to-orange-400 hover:from-yellow-500 hover:via-amber-500 hover:to-orange-500 text-gray-900 font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                            Termin buchen
                        </button>
                </form>
        </div>
    </div>

    <script>
        function acceptOffer() {
            // Verstecke vorherige Meldungen
            document.getElementById('iban-warning-message').classList.add('hidden');
            
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
                    // Seite neu laden, damit die Informationsmeldung angezeigt wird
                    location.reload();
                } else {
                    // Zeige die schöne Warnmeldung statt Alert
                    if (data.message && (data.message.includes('IBAN') || data.message.includes('Geburtsdatum'))) {
                        const warningMessage = document.getElementById('iban-warning-message');
                        warningMessage.classList.remove('hidden');
                        // Scroll zur Meldung
                        warningMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        alert(data.message || 'Fehler beim Annehmen des Angebots');
                    }
                }
                })
                .catch(error => {
                console.error('Error:', error);
                alert('Fehler beim Annehmen des Angebots');
            });
        }

        // Quick Profile Form Handler
        document.getElementById('quick-profile-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const submitBtn = document.getElementById('save-quick-profile-btn');
            const successMsg = document.getElementById('quick-profile-success');
            const ibanError = document.getElementById('iban-error');
            const birthdateError = document.getElementById('birthdate-error');
            
            // Reset errors
            ibanError.classList.add('hidden');
            birthdateError.classList.add('hidden');
            successMsg.classList.add('hidden');
            
            // Get form data
            const formData = new FormData(form);
            
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="ri-loader-4-line text-lg animate-spin"></i> <span>Speichere...</span>';
            
            fetch('{{ route('profile.quick-update') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    successMsg.textContent = 'Erfolgreich gespeichert! Das Angebot wird jetzt angenommen...';
                    successMsg.classList.remove('hidden');
                    
                    // Automatisch das Angebot annehmen
                    setTimeout(() => {
                        acceptOffer();
                    }, 1000);
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        if (data.errors.iban) {
                            ibanError.textContent = data.errors.iban[0];
                            ibanError.classList.remove('hidden');
                        }
                        if (data.errors.birth_day || data.errors.birth_month || data.errors.birth_year) {
                            birthdateError.textContent = 'Bitte wählen Sie ein gültiges Geburtsdatum aus.';
                            birthdateError.classList.remove('hidden');
                        }
                    } else {
                        alert(data.message || 'Fehler beim Speichern');
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="ri-save-line text-lg"></i> <span>Speichern</span>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Fehler beim Speichern. Bitte versuchen Sie es erneut.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="ri-save-line text-lg"></i> <span>Speichern</span>';
            });
        });

        function openAppointmentModal() {
            @if($hasUpcomingAppointment ?? false)
                alert('Sie haben bereits einen Termin gebucht. Bitte stornieren Sie zuerst Ihren bestehenden Termin.');
                return;
            @endif
            document.getElementById('appointmentModal').classList.remove('hidden');
            loadAvailableSlots();
        }

        function rescheduleAppointment(appointmentId) {
            if (!confirm('Möchten Sie wirklich Ihren Termin umbuchen? Der aktuelle Termin wird storniert und Sie können einen neuen Termin auswählen.')) {
                return;
            }

            fetch(`/appointment/${appointmentId}/cancel`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Speichere in localStorage, dass das Modal geöffnet werden soll
                    localStorage.setItem('openAppointmentModal', 'true');
                    // Seite neu laden
                    location.reload();
                } else {
                    alert(data.message || 'Fehler beim Stornieren des Termins');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Fehler beim Stornieren des Termins');
            });
        }

        // Prüfe beim Laden der Seite, ob das Modal geöffnet werden soll
        document.addEventListener('DOMContentLoaded', function() {
            if (localStorage.getItem('openAppointmentModal') === 'true') {
                localStorage.removeItem('openAppointmentModal');
                setTimeout(() => {
                    document.getElementById('appointmentModal').classList.remove('hidden');
                }, 300);
            }
        });

        function closeAppointmentModal() {
            document.getElementById('appointmentModal').classList.add('hidden');
        }

        function loadAvailableSlots() {
            const date = document.getElementById('appointmentDate').value;
            const select = document.getElementById('timeSlotSelect');
            
            if (!date) {
                select.innerHTML = '<option value="">Bitte wählen Sie zuerst ein Datum aus</option>';
                select.disabled = true;
                return;
            }

            select.innerHTML = '<option value="">Lade verfügbare Zeiten...</option>';
            select.disabled = true;

            fetch(`{{ route('appointment.available-slots') }}?date=${date}`, {
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                if (data.success) {
                    select.innerHTML = '<option value="">Bitte Uhrzeit wählen</option>';
                    
                    if (data.slots.length === 0) {
                        select.innerHTML = '<option value="">Keine Termine verfügbar</option>';
                        select.disabled = true;
                        if (data.message) {
                            console.log(data.message);
                        }
                        return;
                    }

                    data.slots.forEach(slot => {
                        const option = document.createElement('option');
                        option.value = slot.time;
                        option.textContent = slot.time + ' Uhr';
                        
                        if (!slot.available) {
                            option.disabled = true;
                            option.textContent += ' (Bereits gebucht)';
                            option.style.color = '#9CA3AF';
                            option.style.backgroundColor = '#F3F4F6';
                        }
                        
                        select.appendChild(option);
                    });
                    
                    select.disabled = false;
                } else {
                    select.innerHTML = '<option value="">Fehler beim Laden: ' + (data.message || 'Unbekannter Fehler') + '</option>';
                    select.disabled = true;
                    console.error('Error from server:', data);
                }
            })
            .catch(error => {
                console.error('Error loading slots:', error);
                select.innerHTML = '<option value="">Fehler beim Laden der Zeiten. Bitte versuchen Sie es erneut.</option>';
                select.disabled = true;
            });
        }

        document.getElementById('appointmentDate').addEventListener('change', loadAvailableSlots);

        document.getElementById('appointmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const date = document.getElementById('appointmentDate').value;
            const time = document.getElementById('timeSlotSelect').value;
            
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
                    // Seite neu laden, damit der Info-Container erscheint
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

        // IBAN Info Modal Functions
        function openIbanInfoModal() {
            document.getElementById('ibanInfoModal').classList.remove('hidden');
        }

        function closeIbanInfoModal() {
            document.getElementById('ibanInfoModal').classList.add('hidden');
        }

        document.getElementById('ibanInfoModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeIbanInfoModal();
            }
        });
    </script>
</x-app-layout>

