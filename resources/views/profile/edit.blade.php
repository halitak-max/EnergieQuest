<x-app-layout>
    @php
        // Extract first name and last name from name
        $nameParts = explode(' ', $user->name, 2);
        $firstName = old('first_name', $nameParts[0] ?? '');
        $lastName = old('last_name', $nameParts[1] ?? '');
        
        // Extract address components (if available, otherwise use placeholders)
        // Try to parse from current_location if available (format: "PLZ Ort" or "Ort")
        $address = old('address', 'Im Brühl 4');
        $postalCode = old('postal_code', '89437');
        $city = old('city', 'Haunsheim');
        
        if ($user->current_location) {
            // Try to parse "89437 Haunsheim" or similar
            if (preg_match('/^(\d+)\s+(.+)$/', $user->current_location, $matches)) {
                $postalCode = $matches[1];
                $city = $matches[2];
            } elseif (preg_match('/^\d+$/', $user->current_location)) {
                $postalCode = $user->current_location;
            } else {
                $city = $user->current_location;
            }
        }
        
        // Extract birth date components
        $birthDate = old('birth_date', $user->birth_date);
        $birthDay = $birthDate ? date('j', strtotime($birthDate)) : old('birth_day', '');
        $birthMonth = $birthDate ? date('n', strtotime($birthDate)) : old('birth_month', '');
        $birthYear = $birthDate ? date('Y', strtotime($birthDate)) : old('birth_year', '');
    @endphp

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-24">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Mein Profil</h1>
            <p class="text-gray-600">Verwalte deine persönlichen Informationen und Einstellungen</p>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                    <!-- User Profile Summary -->
                    <div class="flex flex-col items-center mb-6">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white text-2xl font-bold mb-3">
                            @php
                                $initials = strtoupper(substr($user->name, 0, 2));
                            @endphp
                            {{ $initials }}
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>

                    <!-- Navigation -->
                    <div class="space-y-1">
                        <button onclick="showSection('profile')" id="btn-profile" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all cursor-pointer whitespace-nowrap bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-md">
                            <i class="ri-user-line text-lg"></i>
                            <span>Profilinformationen</span>
                        </button>
                        <button onclick="showSection('security')" id="btn-security" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all cursor-pointer whitespace-nowrap text-gray-700 hover:bg-gray-100">
                            <i class="ri-shield-line text-lg"></i>
                            <span>Sicherheit</span>
                        </button>
                        <button onclick="showSection('privacy')" id="btn-privacy" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all cursor-pointer whitespace-nowrap text-gray-700 hover:bg-gray-100">
                            <i class="ri-file-text-line text-lg"></i>
                            <span>Datenschutz</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Profile Information Section -->
                <div id="section-profile" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Profilinformationen</h2>
                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf
                            @method('patch')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">Vorname</label>
                                    <input id="first_name" name="first_name" type="text" value="{{ $firstName }}" required autofocus autocomplete="given-name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">Nachname</label>
                                    <input id="last_name" name="last_name" type="text" value="{{ $lastName }}" required autocomplete="family-name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">E-Mail-Adresse</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Telefonnummer</label>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone', $user->phone) }}" required autocomplete="tel" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>

                            <div>
                                <label for="iban" class="block text-sm font-medium text-gray-700 mb-2">IBAN</label>
                                <input id="iban" name="iban" type="text" value="{{ old('iban', $user->iban) }}" autocomplete="off" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                <x-input-error class="mt-2" :messages="$errors->get('iban')" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Geburtsdatum</label>
                                <div class="flex gap-2">
                                    <select id="birth_day" name="birth_day" class="block w-20 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
                                        <option value="">Tag</option>
                                        @for($i = 1; $i <= 31; $i++)
                                            <option value="{{ $i }}" {{ $birthDay == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                    <select id="birth_month" name="birth_month" class="block w-32 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
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
                                    <select id="birth_year" name="birth_year" class="block w-24 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required>
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

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                                <input id="address" name="address" type="text" value="{{ $address }}" autocomplete="street-address" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">PLZ</label>
                                    <input id="postal_code" name="postal_code" type="text" value="{{ $postalCode }}" autocomplete="postal-code" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">Ort</label>
                                    <input id="city" name="city" type="text" value="{{ $city }}" autocomplete="address-level2" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                </div>
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-lg font-medium hover:shadow-lg transition-all cursor-pointer whitespace-nowrap">
                                    Änderungen speichern
                                </button>
                            </div>

                            @if (session('status') === 'profile-updated')
                                <p class="text-sm text-green-600 mt-4">Profil erfolgreich aktualisiert.</p>
                            @endif
                        </form>
                    </div>
                </div>

                <!-- Security Section -->
                <div id="section-security" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 hidden">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Sicherheit</h2>
                        <div class="space-y-6">
                            <!-- Passwort ändern Card -->
                            <div class="border border-gray-200 rounded-lg p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Passwort ändern</h3>
                                        <p class="text-sm text-gray-600 mt-1">Aktualisiere dein Passwort regelmäßig</p>
                                    </div>
                                    <button onclick="openPasswordModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors cursor-pointer whitespace-nowrap">Ändern</button>
                                </div>
                            </div>

                            <!-- Abmelden Card -->
                            <div class="border border-gray-200 rounded-lg p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">Abmelden</h3>
                                        <p class="text-sm text-gray-600 mt-1">Von deinem Konto abmelden</p>
                                    </div>
                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-500 text-white rounded-lg font-medium hover:from-amber-600 hover:to-orange-600 hover:shadow-lg transition-all cursor-pointer whitespace-nowrap">Jetzt abmelden</button>
                                    </form>
                                </div>
                            </div>

                            <!-- Konto löschen Card -->
                            <div class="border border-red-200 rounded-lg p-6 bg-red-50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold text-red-900">Konto löschen</h3>
                                        <p class="text-sm text-red-700 mt-1">Diese Aktion kann nicht rückgängig gemacht werden</p>
                                    </div>
                                    <button onclick="openDeleteModal()" class="px-4 py-2 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition-colors cursor-pointer whitespace-nowrap">Konto löschen</button>
                                </div>
                            </div>
                        </div>
                </div>
            </div>

                <!-- Privacy Section -->
                <div id="section-privacy" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 hidden">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Datenschutz</h2>
                        <div class="space-y-6">
                            <!-- Datenschutzerklärung Card -->
                            <div class="border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Datenschutzerklärung</h3>
                                <p class="text-sm text-gray-600 mb-4">Erfahre mehr darüber, wie wir deine Daten schützen und verwenden.</p>
                            <a href="{{ route('datenschutz') }}">
                                    <button class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-lg font-medium hover:shadow-lg transition-all cursor-pointer whitespace-nowrap">
                                        Datenschutzerklärung lesen
                                    </button>
                                </a>
                            </div>

                            <!-- Deine Rechte Card -->
                            <div class="border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-4">Deine Rechte</h3>
                                <ul class="space-y-3">
                                    <li class="flex items-start gap-3">
                                        <i class="ri-check-line text-green-500 text-xl mt-0.5 flex-shrink-0"></i>
                                        <span class="text-sm text-gray-700">Recht auf Auskunft über deine gespeicherten Daten</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="ri-check-line text-green-500 text-xl mt-0.5 flex-shrink-0"></i>
                                        <span class="text-sm text-gray-700">Recht auf Berichtigung falscher Daten</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="ri-check-line text-green-500 text-xl mt-0.5 flex-shrink-0"></i>
                                        <span class="text-sm text-gray-700">Recht auf Löschung deiner Daten</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="ri-check-line text-green-500 text-xl mt-0.5 flex-shrink-0"></i>
                                        <span class="text-sm text-gray-700">Recht auf Einschränkung der Verarbeitung</span>
                                    </li>
                                    <li class="flex items-start gap-3">
                                        <i class="ri-check-line text-green-500 text-xl mt-0.5 flex-shrink-0"></i>
                                        <span class="text-sm text-gray-700">Recht auf Datenübertragbarkeit</span>
                                    </li>
                                </ul>
                            </div>

                            <!-- Kontakt Card -->
                            <div class="border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">Kontakt</h3>
                                <p class="text-sm text-gray-600 mb-3">Bei Fragen zum Datenschutz kannst du uns jederzeit kontaktieren:</p>
                                <a href="mailto:info@energiequest.de" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    info@energiequest.de
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Password Change Modal -->
    <div id="password-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Passwort ändern</h3>
                <form method="post" action="{{ route('password.update') }}" class="space-y-4">
                            @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Aktuelles Passwort</label>
                        <input id="current_password" name="current_password" type="password" required autocomplete="current-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Neues Passwort</label>
                        <input id="password" name="password" type="password" required autocomplete="new-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Passwort bestätigen</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closePasswordModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors cursor-pointer whitespace-nowrap">Abbrechen</button>
                        <button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-lg font-medium hover:shadow-lg transition-all cursor-pointer whitespace-nowrap">Speichern</button>
                    </div>

                    @if (session('status') === 'password-updated')
                        <p class="text-sm text-green-600 mt-4">Passwort erfolgreich geändert.</p>
                    @endif
                        </form>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Konto löschen</h3>
                <p class="text-sm text-gray-600 mb-4">Sobald Ihr Konto gelöscht ist, werden alle Ressourcen und Daten dauerhaft gelöscht. Bitte geben Sie Ihr Passwort ein, um zu bestätigen, dass Sie Ihr Konto dauerhaft löschen möchten.</p>
                <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                    @csrf
                    @method('delete')

                    <div>
                        <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-2">Passwort</label>
                        <input id="delete_password" name="password" type="password" required placeholder="Passwort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition-colors cursor-pointer whitespace-nowrap">Abbrechen</button>
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition-colors cursor-pointer whitespace-nowrap">Konto löschen</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showSection(section) {
            // Hide all sections
            document.getElementById('section-profile').classList.add('hidden');
            document.getElementById('section-security').classList.add('hidden');
            document.getElementById('section-privacy').classList.add('hidden');

            // Remove active state from all buttons
            document.getElementById('btn-profile').classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-indigo-500', 'text-white', 'shadow-md');
            document.getElementById('btn-profile').classList.add('text-gray-700', 'hover:bg-gray-100');
            document.getElementById('btn-security').classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-indigo-500', 'text-white', 'shadow-md');
            document.getElementById('btn-security').classList.add('text-gray-700', 'hover:bg-gray-100');
            document.getElementById('btn-privacy').classList.remove('bg-gradient-to-r', 'from-blue-500', 'to-indigo-500', 'text-white', 'shadow-md');
            document.getElementById('btn-privacy').classList.add('text-gray-700', 'hover:bg-gray-100');

            // Show selected section
            document.getElementById('section-' + section).classList.remove('hidden');

            // Add active state to selected button
            const activeButton = document.getElementById('btn-' + section);
            activeButton.classList.remove('text-gray-700', 'hover:bg-gray-100');
            activeButton.classList.add('bg-gradient-to-r', 'from-blue-500', 'to-indigo-500', 'text-white', 'shadow-md');
        }

        function openPasswordModal() {
            document.getElementById('password-modal').classList.remove('hidden');
        }

        function closePasswordModal() {
            document.getElementById('password-modal').classList.add('hidden');
        }

        function openDeleteModal() {
            document.getElementById('delete-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-modal').classList.add('hidden');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const passwordModal = document.getElementById('password-modal');
            const deleteModal = document.getElementById('delete-modal');
            if (event.target == passwordModal) {
                closePasswordModal();
            }
            if (event.target == deleteModal) {
                closeDeleteModal();
            }
        }

        // Initial active section - show Profile by default
        document.addEventListener('DOMContentLoaded', () => {
            showSection('profile');
        });
    </script>
</x-app-layout>
