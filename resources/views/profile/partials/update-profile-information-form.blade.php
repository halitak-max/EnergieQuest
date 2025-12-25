<section>
    <!-- Meldung wenn Angebot angenommen wurde -->
    <div id="offer-accepted-message" class="hidden mb-4 px-4 py-3 rounded relative text-center" role="alert" style="background-color: #FEE2E2; border: 1px solid #FCA5A5; color: #991B1B;">
        <span class="block sm:inline font-bold">Sobald Sie Ihren Auftrag per E-mail erhalten haben, können Sie wieder hier Änderungen durchführen.</span>
    </div>
    
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profilinformationen') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Aktualisieren Sie Ihre Profilinformationen und E-Mail-Adresse.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    @php
        // Extract first name and last name from name
        $nameParts = explode(' ', $user->name, 2);
        $firstName = old('first_name', $nameParts[0] ?? '');
        $lastName = old('last_name', $nameParts[1] ?? '');
        
        // Extract birth date components
        $birthDate = old('birth_date', $user->birth_date);
        $birthDay = $birthDate ? date('j', strtotime($birthDate)) : old('birth_day', '');
        $birthMonth = $birthDate ? date('n', strtotime($birthDate)) : old('birth_month', '');
        $birthYear = $birthDate ? date('Y', strtotime($birthDate)) : old('birth_year', '');
    @endphp

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="first_name" :value="__('Vorname')" />
            <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full text-center profile-field" :value="$firstName" required autofocus autocomplete="given-name" />
            <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
        </div>

        <div>
            <x-input-label for="last_name" :value="__('Nachname')" />
            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full text-center profile-field" :value="$lastName" required autocomplete="family-name" />
            <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('E-Mail')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full text-center profile-field" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Ihre E-Mail-Adresse ist nicht verifiziert.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Klicken Sie hier, um die Verifizierungs-E-Mail erneut zu senden.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Ein neuer Verifizierungslink wurde an Ihre E-Mail-Adresse gesendet.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="phone" :value="__('Telefonnummer')" />
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full text-center profile-field" :value="old('phone', $user->phone)" required autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="iban" :value="__('IBAN')" />
            <x-text-input id="iban" name="iban" type="text" class="mt-1 block w-full text-center profile-field" :value="old('iban', $user->iban)" autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('iban')" />
        </div>

        <div>
            <x-input-label :value="__('Geburtsdatum')" />
            <div class="mt-1 flex gap-2 justify-center">
                <select id="birth_day" name="birth_day" class="block w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 profile-field" required>
                    <option value="">Tag</option>
                    @for($i = 1; $i <= 31; $i++)
                        <option value="{{ $i }}" {{ $birthDay == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
                <select id="birth_month" name="birth_month" class="block w-32 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 profile-field" required>
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
                <select id="birth_year" name="birth_year" class="block w-24 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 profile-field" required>
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
            <x-input-error class="mt-2" :messages="$errors->get('birth_date')" />
            <x-input-error class="mt-2" :messages="$errors->get('birth_day')" />
            <x-input-error class="mt-2" :messages="$errors->get('birth_month')" />
            <x-input-error class="mt-2" :messages="$errors->get('birth_year')" />
        </div>

        <div class="flex flex-col items-center gap-4">
            <x-primary-button id="save-profile-btn" type="submit" class="profile-action-btn">{{ __('Speichern') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 bg-green-100 px-4 py-2 rounded-md"
                >{{ __('Gespeichert.') }}</p>
            @endif
        </div>
    </form>
    
    <style>
        .field-warning-bg {
            background-color: #FEE2E2 !important;
        }
        .profile-field-disabled {
            background-color: #E5E7EB !important;
            color: #9CA3AF !important;
            cursor: not-allowed !important;
            opacity: 0.6;
        }
        .profile-action-btn-disabled {
            background-color: #E5E7EB !important;
            color: #9CA3AF !important;
            cursor: not-allowed !important;
            opacity: 0.6;
            pointer-events: none;
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hole den aktuellen Status vom Server
            fetch('{{ route("offer.status") }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const offerAcceptedDb = data.offer_accepted || false;
                updateProfileFields(offerAcceptedDb);
            })
            .catch(error => {
                console.error('Error fetching offer status:', error);
                // Fallback auf PHP-Wert
                @php
                    $offerAcceptedDb = Auth::user()->offer_accepted ?? false;
                @endphp
                const offerAcceptedDb = @json($offerAcceptedDb);
                updateProfileFields(offerAcceptedDb);
            });
            
            // Speichere die ursprünglichen Event-Handler
            let formSubmitHandler = null;
            let deleteBtnClickHandler = null;
            
            function updateProfileFields(offerAccepted) {
                const offerAcceptedMessage = document.getElementById('offer-accepted-message');
                const profileFields = document.querySelectorAll('.profile-field');
                const profileForm = document.querySelector('form[method="post"][action*="profile.update"]');
                const actionButtons = document.querySelectorAll('.profile-action-btn');
                const deleteAccountBtn = document.getElementById('delete-account-btn');
                
                // Entferne alte Event-Listener falls vorhanden
                if (profileForm && formSubmitHandler) {
                    profileForm.removeEventListener('submit', formSubmitHandler);
                    formSubmitHandler = null;
                }
                if (deleteAccountBtn && deleteBtnClickHandler) {
                    deleteAccountBtn.removeEventListener('click', deleteBtnClickHandler);
                    deleteBtnClickHandler = null;
                }
                
                // Prüfe ob Profil gesperrt ist (offer_accepted = true bedeutet gesperrt)
                if (offerAccepted) {
                    // Zeige Meldung
                    if (offerAcceptedMessage) {
                        offerAcceptedMessage.classList.remove('hidden');
                    }
                    
                    // Deaktiviere alle Felder
                    profileFields.forEach(field => {
                        field.disabled = true;
                        field.classList.add('profile-field-disabled');
                    });
                    
                    // Deaktiviere alle Action-Buttons (Speichern, Konto löschen)
                    actionButtons.forEach(button => {
                        button.disabled = true;
                        button.classList.add('profile-action-btn-disabled');
                    });
                    
                    // Verhindere Formular-Submit und zeige Meldung
                    if (profileForm) {
                        formSubmitHandler = function(e) {
                            e.preventDefault();
                            // Zeige Meldung
                            if (offerAcceptedMessage) {
                                offerAcceptedMessage.classList.remove('hidden');
                                offerAcceptedMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                            return false;
                        };
                        profileForm.addEventListener('submit', formSubmitHandler);
                    }
                    
                    // Verhindere Klick auf Konto löschen Button
                    if (deleteAccountBtn) {
                        deleteBtnClickHandler = function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            // Zeige Meldung
                            if (offerAcceptedMessage) {
                                offerAcceptedMessage.classList.remove('hidden');
                                offerAcceptedMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                            return false;
                        };
                        deleteAccountBtn.addEventListener('click', deleteBtnClickHandler);
                    }
                } else {
                    // Profil ist freigeschaltet (offer_accepted = false), mache alle Felder bearbeitbar
                    if (offerAcceptedMessage) {
                        offerAcceptedMessage.classList.add('hidden');
                    }
                    
                    // Aktiviere alle Felder
                    profileFields.forEach(field => {
                        field.disabled = false;
                        field.classList.remove('profile-field-disabled');
                    });
                    
                    // Aktiviere alle Action-Buttons
                    actionButtons.forEach(button => {
                        button.disabled = false;
                        button.classList.remove('profile-action-btn-disabled');
                    });
                }
            }
            
            // Prüfe regelmäßig, ob sich der Status geändert hat
            setInterval(function() {
                fetch('{{ route("offer.status") }}', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const offerAcceptedDb = data.offer_accepted || false;
                    updateProfileFields(offerAcceptedDb);
                })
                .catch(error => {
                    console.error('Error fetching offer status:', error);
                });
            }, 2000); // Alle 2 Sekunden prüfen
            
            const ibanField = document.getElementById('iban');
            const birthDayField = document.getElementById('birth_day');
            const birthMonthField = document.getElementById('birth_month');
            const birthYearField = document.getElementById('birth_year');
            
            // Prüfe ob die Felder gefunden wurden
            if (!ibanField || !birthDayField || !birthMonthField || !birthYearField) {
                console.error('Felder nicht gefunden:', {
                    iban: !!ibanField,
                    birthDay: !!birthDayField,
                    birthMonth: !!birthMonthField,
                    birthYear: !!birthYearField
                });
            }
            
            // Funktion zum Prüfen ob Geburtsdatum leer ist
            function isBirthDateEmpty() {
                return !birthDayField.value || !birthMonthField.value || !birthYearField.value;
            }
            
            // Funktion zum Setzen der Hintergrundfarbe
            function setFieldBackground(field, isEmpty) {
                if (!field) return;
                
                const offerButtonClicked = localStorage.getItem('offerButtonClicked') === 'true';
                if (offerButtonClicked && isEmpty) {
                    // Verwende sowohl inline-Style als auch CSS-Klasse
                    field.style.setProperty('background-color', '#FEE2E2', 'important');
                    field.classList.add('field-warning-bg');
                } else {
                    field.style.removeProperty('background-color');
                    field.classList.remove('field-warning-bg');
                }
            }
            
            // Funktion zum Aktualisieren aller Hintergrundfarben
            function updateAllFieldBackgrounds() {
                setFieldBackground(ibanField, !ibanField.value);
                const isEmpty = isBirthDateEmpty();
                setFieldBackground(birthDayField, isEmpty);
                setFieldBackground(birthMonthField, isEmpty);
                setFieldBackground(birthYearField, isEmpty);
            }
            
            // Initiale Prüfung und Setzen der Hintergrundfarbe
            // Warte kurz, damit die Felder vollständig geladen sind
            setTimeout(function() {
                updateAllFieldBackgrounds();
            }, 100);
            
            // Prüfe regelmäßig, ob sich der Status geändert hat
            setInterval(function() {
                updateAllFieldBackgrounds();
            }, 500);
            
            // Funktion zum Aktualisieren des Ausrufezeichens
            function updateWarningIcon() {
                const warningIcon = document.getElementById('profile-warning-icon');
                if (warningIcon) {
                    const offerButtonClicked = localStorage.getItem('offerButtonClicked') === 'true';
                    const fieldsComplete = ibanField.value && !isBirthDateEmpty();
                    
                    if (fieldsComplete || !offerButtonClicked) {
                        warningIcon.classList.add('hidden');
                    } else if (offerButtonClicked) {
                        warningIcon.classList.remove('hidden');
                    }
                }
            }
            
            // Event-Listener für IBAN
            ibanField.addEventListener('input', function() {
                setFieldBackground(ibanField, !this.value);
                // Wenn IBAN ausgefüllt ist, entferne den Flag wenn auch Geburtsdatum ausgefüllt ist
                if (this.value && !isBirthDateEmpty()) {
                    localStorage.removeItem('offerButtonClicked');
                    updateAllFieldBackgrounds();
                    updateWarningIcon();
                } else {
                    updateWarningIcon();
                }
            });
            
            // Event-Listener für Geburtsdatum-Felder
            function handleBirthDateChange() {
                const isEmpty = isBirthDateEmpty();
                setFieldBackground(birthDayField, isEmpty);
                setFieldBackground(birthMonthField, isEmpty);
                setFieldBackground(birthYearField, isEmpty);
                
                // Wenn Geburtsdatum ausgefüllt ist, entferne den Flag wenn auch IBAN ausgefüllt ist
                if (!isEmpty && ibanField.value) {
                    localStorage.removeItem('offerButtonClicked');
                    updateAllFieldBackgrounds();
                    updateWarningIcon();
                } else {
                    updateWarningIcon();
                }
            }
            
            birthDayField.addEventListener('change', handleBirthDateChange);
            birthMonthField.addEventListener('change', handleBirthDateChange);
            birthYearField.addEventListener('change', handleBirthDateChange);
            
            // Event-Listener für Storage-Änderungen (wenn LocalStorage in einem anderen Tab geändert wird)
            window.addEventListener('storage', function(e) {
                if (e.key === 'offerButtonClicked') {
                    updateAllFieldBackgrounds();
                    updateWarningIcon();
                }
            });
            
            // Initiale Aktualisierung des Ausrufezeichens
            updateWarningIcon();
        });
    </script>
</section>
