<x-guest-layout>
    <div x-data="{
        currentStep: 1,
        totalSteps: 4,
        formData: {
            first_name: '',
            last_name: '',
            email: '',
            password: '',
            password_confirmation: '',
            phone: '',
            referral_code: '{{ old('referral_code', $referral_code ?? request('ref')) }}',
            privacy_policy: false
        },
        showPassword: false,
        errors: {},
        nextStep() {
            if (this.validateStep(this.currentStep)) {
                if (this.currentStep < this.totalSteps) {
                    this.currentStep++;
                }
            }
        },
        prevStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
            }
        },
        validateStep(step) {
            this.errors = {};
            let isValid = true;
            
            if (step === 1) {
                if (!this.formData.first_name || this.formData.first_name.trim() === '') {
                    this.errors.first_name = 'Bitte gib deinen Vornamen ein.';
                    isValid = false;
                }
                if (!this.formData.last_name || this.formData.last_name.trim() === '') {
                    this.errors.last_name = 'Bitte gib deinen Nachnamen ein.';
                    isValid = false;
                }
            } else if (step === 2) {
                if (!this.formData.email || this.formData.email.trim() === '') {
                    this.errors.email = 'Bitte gib deine E-Mail-Adresse ein.';
                    isValid = false;
                } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.formData.email)) {
                    this.errors.email = 'Bitte gib eine gültige E-Mail-Adresse ein.';
                    isValid = false;
                }
            } else if (step === 3) {
                if (!this.formData.password || this.formData.password === '') {
                    this.errors.password = 'Bitte gib ein Passwort ein.';
                    isValid = false;
                } else if (this.formData.password.length < 8) {
                    this.errors.password = 'Das Passwort muss mindestens 8 Zeichen lang sein.';
                    isValid = false;
                }
                if (!this.formData.password_confirmation || this.formData.password_confirmation === '') {
                    this.errors.password_confirmation = 'Bitte bestätige dein Passwort.';
                    isValid = false;
                } else if (this.formData.password !== this.formData.password_confirmation) {
                    this.errors.password_confirmation = 'Die Passwörter stimmen nicht überein.';
                    isValid = false;
                }
            } else if (step === 4) {
                if (!this.formData.phone || this.formData.phone.trim() === '') {
                    this.errors.phone = 'Bitte gib deine Telefonnummer ein.';
                    isValid = false;
                }
                if (!this.formData.privacy_policy) {
                    this.errors.privacy_policy = 'Bitte akzeptiere die Datenschutzerklärung.';
                    isValid = false;
                }
            }
            
            return isValid;
        },
        submitForm() {
            if (this.validateStep(this.currentStep)) {
                document.getElementById('name').value = this.formData.first_name + ' ' + this.formData.last_name;
                document.getElementById('first_name').value = this.formData.first_name;
                document.getElementById('last_name').value = this.formData.last_name;
                document.getElementById('email').value = this.formData.email;
                document.getElementById('password').value = this.formData.password;
                document.getElementById('password_confirmation').value = this.formData.password_confirmation;
                document.getElementById('phone').value = this.formData.phone;
                
                if (this.formData.referral_code) {
                    const referralInput = document.getElementById('referral_code');
                    if (referralInput) referralInput.value = this.formData.referral_code;
                }
                
                const privacyInput = document.getElementById('privacy_policy');
                if (privacyInput) {
                    privacyInput.value = this.formData.privacy_policy ? '1' : '0';
                }
                
                document.getElementById('register-form').submit();
            }
        }
    }">

        <h1 class="text-xl font-semibold text-gray-800 mb-1">Konto erstellen</h1>
        <p class="text-xs text-gray-600 mb-4">In wenigen Schritten zu deinem persönlichen Konto</p>

        @if(isset($referrer_name))
        <div class="bg-green-50 border border-green-200 rounded-md p-3 mb-4 text-sm text-green-700 font-medium text-center">
            Empfohlen von {{ $referrer_name }}
        </div>
        @endif

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form id="register-form" method="POST" action="{{ route('register') }}">
            @csrf

            <input type="hidden" id="name" name="name" value="">
            <input type="hidden" id="first_name" name="first_name" value="">
            <input type="hidden" id="last_name" name="last_name" value="">
            <input type="hidden" id="email" name="email" value="">
            <input type="hidden" id="password" name="password" value="">
            <input type="hidden" id="password_confirmation" name="password_confirmation" value="">
            <input type="hidden" id="phone" name="phone" value="">
            @if(isset($referrer_name))
                <input type="hidden" name="referral_code" value="{{ $referral_code }}">
            @else
                <input type="hidden" id="referral_code" name="referral_code" :value="formData.referral_code">
            @endif
            <input type="hidden" id="privacy_policy" name="privacy_policy" value="0">

            <div class="form-container">
                <!-- Step 1: First Name and Last Name -->
                <div class="step-content active" :class="{ 'active': currentStep === 1 }" x-show="currentStep === 1" style="display: block;">
                    <div class="form-group mb-3">
                        <label for="first_name_input" class="block text-xs font-medium text-gray-700 mb-1">Vorname</label>
                        <input id="first_name_input" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                               :class="{ 'border-red-500': errors.first_name }"
                               type="text" 
                               x-model="formData.first_name"
                               required 
                               autofocus 
                               autocomplete="given-name" />
                        <span x-show="errors.first_name" class="text-xs text-red-600 mt-1 block" x-text="errors.first_name"></span>
                    </div>

                    <div class="form-group mb-4">
                        <label for="last_name_input" class="block text-xs font-medium text-gray-700 mb-1">Nachname</label>
                        <input id="last_name_input" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                               :class="{ 'border-red-500': errors.last_name }"
                               type="text" 
                               x-model="formData.last_name"
                               required 
                               autocomplete="family-name" />
                        <span x-show="errors.last_name" class="text-xs text-red-600 mt-1 block" x-text="errors.last_name"></span>
                    </div>

                    <div class="button-group flex justify-between items-center">
                        <a href="{{ route('login') }}" class="text-xs text-blue-600 hover:text-blue-700 whitespace-nowrap">
                            Bereits registriert?
                        </a>
                        <button type="button" @click="nextStep()" class="bg-blue-600 text-white px-5 py-2 text-xs rounded-md hover:bg-blue-700 transition-colors font-medium whitespace-nowrap cursor-pointer">
                            Weiter
                        </button>
                    </div>

                    <!-- OAuth Buttons -->
                    <div class="mt-4">
                        <div class="relative flex items-center mb-4">
                            <div class="flex-grow border-t border-gray-300"></div>
                            <span class="flex-shrink mx-4 text-gray-500 text-sm">{{ __('oder') }}</span>
                            <div class="flex-grow border-t border-gray-300"></div>
        </div>

                        @php
                            $refCode = old('referral_code', $referral_code ?? request('ref'));
                        @endphp
                        <a href="{{ route('auth.google') }}{{ $refCode ? '?ref=' . urlencode($refCode) : '' }}" class="w-full mb-3 flex items-center justify-center gap-3 px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                            </svg>
                            {{ __('Mit Google anmelden') }}
                        </a>
                        
                        <a href="{{ route('auth.facebook') }}{{ $refCode ? '?ref=' . urlencode($refCode) : '' }}" class="w-full flex items-center justify-center gap-3 px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="#1877F2">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            {{ __('Mit Facebook anmelden') }}
                        </a>
                    </div>
                </div>

                <!-- Step 2: Email -->
                <div class="step-content" :class="{ 'active': currentStep === 2 }" x-show="currentStep === 2">
                    <div class="form-group mb-4">
                        <label for="email_input" class="block text-xs font-medium text-gray-700 mb-1">E-Mail-Adresse</label>
                        <input id="email_input" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                               :class="{ 'border-red-500': errors.email }"
                               type="email" 
                               x-model="formData.email"
                               required 
                               autocomplete="username" />
                        <span x-show="errors.email" class="text-xs text-red-600 mt-1 block" x-text="errors.email"></span>
                        @error('email')
                            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="button-group flex justify-between items-center">
                        <button type="button" @click="prevStep()" class="text-xs text-blue-600 hover:text-blue-700 whitespace-nowrap">
                            Zurück
                        </button>
                        <button type="button" @click="nextStep()" class="bg-blue-600 text-white px-5 py-2 text-xs rounded-md hover:bg-blue-700 transition-colors font-medium whitespace-nowrap cursor-pointer">
                            Weiter
                        </button>
                    </div>
                </div>

                <!-- Step 3: Password -->
                <div class="step-content" :class="{ 'active': currentStep === 3 }" x-show="currentStep === 3">
                    <div class="form-group mb-3">
                        <label for="password_input" class="block text-xs font-medium text-gray-700 mb-1">Passwort</label>
                        <div class="relative">
                            <input id="password_input" 
                                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all pr-10"
                                   :class="{ 'border-red-500': errors.password }"
                                   :type="showPassword ? 'text' : 'password'"
                                   x-model="formData.password"
                                   required 
                                   autocomplete="new-password" />
                            <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <i class="ri-eye-line" x-show="!showPassword"></i>
                                <i class="ri-eye-off-line" x-show="showPassword"></i>
                            </button>
                        </div>
                        <span x-show="errors.password" class="text-xs text-red-600 mt-1 block" x-text="errors.password"></span>
                        @error('password')
                            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label for="password_confirmation_input" class="block text-xs font-medium text-gray-700 mb-1">Passwort bestätigen</label>
                        <input id="password_confirmation_input" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                               :class="{ 'border-red-500': errors.password_confirmation }"
                               type="password"
                               x-model="formData.password_confirmation" 
                               required 
                               autocomplete="new-password" />
                        <span x-show="errors.password_confirmation" class="text-xs text-red-600 mt-1 block" x-text="errors.password_confirmation"></span>
                        @error('password_confirmation')
                            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="button-group flex justify-between items-center">
                        <button type="button" @click="prevStep()" class="text-xs text-blue-600 hover:text-blue-700 whitespace-nowrap">
                            Zurück
                        </button>
                        <button type="button" @click="nextStep()" class="bg-blue-600 text-white px-5 py-2 text-xs rounded-md hover:bg-blue-700 transition-colors font-medium whitespace-nowrap cursor-pointer">
                            Weiter
                        </button>
                    </div>
                </div>

                <!-- Step 4: Phone, Privacy Policy and Submit -->
                <div class="step-content" :class="{ 'active': currentStep === 4 }" x-show="currentStep === 4">
                    <div class="form-group mb-3">
                        <label for="phone_input" class="block text-xs font-medium text-gray-700 mb-1">Telefonnummer</label>
                        <input id="phone_input" 
                               class="w-full px-3 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                               :class="{ 'border-red-500': errors.phone }"
                               type="tel" 
                               x-model="formData.phone"
                               required 
                               autocomplete="tel" />
                        <span x-show="errors.phone" class="text-xs text-red-600 mt-1 block" x-text="errors.phone"></span>
                        @error('phone')
                            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <div class="flex items-start">
                            <input id="privacy_policy_input" 
                                   type="checkbox" 
                                   x-model="formData.privacy_policy"
                                   required 
                                   value="1"
                                   class="mt-1 mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label for="privacy_policy_input" class="text-xs text-gray-700">
                                Ich akzeptiere die <a href="{{ route('datenschutz') }}" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation();" class="text-blue-600 hover:text-blue-700 underline">Datenschutzerklärung</a>
                </label>
            </div>
                        <span x-show="errors.privacy_policy" class="text-xs text-red-600 mt-1 block" x-text="errors.privacy_policy"></span>
                        @error('privacy_policy')
                            <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
                        @enderror
        </div>

                    <div class="button-group flex justify-between items-center">
                        <button type="button" @click="prevStep()" class="text-xs text-blue-600 hover:text-blue-700 whitespace-nowrap">
                            Zurück
                        </button>
                        <button type="button" @click="submitForm()" class="bg-blue-600 text-white px-5 py-2 text-xs rounded-md hover:bg-blue-700 transition-colors font-medium whitespace-nowrap cursor-pointer">
                            Registrieren
                        </button>
                    </div>
                </div>
        </div>
    </form>
    </div>

    <x-slot name="footer">
        <div class="w-full sm:max-w-md mt-3 px-4 sm:px-0">
            <div class="flex flex-col items-center relative pb-8 w-full mx-auto">
                <x-speech-bubble />
                <x-yellow-emoji />
            </div>
       </div>
    </x-slot>

    <style>
        .form-container {
            min-height: 300px;
            position: relative;
        }
        .step-content {
            display: none;
        }
        .step-content.active {
            display: block;
        }
    </style>
</x-guest-layout>
