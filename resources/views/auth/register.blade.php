<x-guest-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Google-style form styling */
        .google-input {
            width: 100%;
            padding: 13px 15px;
            font-size: 16px;
            border: 1px solid #dadce0;
            border-radius: 4px;
            background-color: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
        }
        .google-input:focus {
            outline: none;
            border-color: #1a73e8;
            box-shadow: 0 0 0 1px #1a73e8;
        }
        .google-input-error {
            border-color: #ea4335;
        }
        .google-label {
            display: block;
            color: #5f6368;
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 8px;
            text-align: left;
        }
        .google-button {
            background-color: #1a73e8;
            color: white;
            border: none;
            padding: 10px 24px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            cursor: pointer;
            min-width: 88px;
            min-height: 36px;
            transition: background-color 0.2s, box-shadow 0.2s;
        }
        .google-button:hover:not(:disabled) {
            background-color: #1765cc;
            box-shadow: 0 1px 2px 0 rgba(60,64,67,.3), 0 1px 3px 1px rgba(60,64,67,.15);
        }
        .google-button:active:not(:disabled) {
            background-color: #1557b0;
        }
        .google-button:disabled {
            background-color: #f8f9fa;
            color: #5f6368;
            cursor: not-allowed;
        }
        .google-button-secondary {
            background-color: transparent;
            color: #1a73e8;
            border: none;
            padding: 10px 24px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }
        .google-button-secondary:hover {
            background-color: rgba(26, 115, 232, 0.08);
        }
        .referral-banner {
            background-color: #DCFCE7;
            border: 1px solid #15803D;
            border-radius: 4px;
            padding: 12px 16px;
            margin-bottom: 24px;
            text-align: center;
            font-size: 14px;
            color: #15803D;
            font-weight: 500;
        }
        .error-message {
            color: #ea4335;
            font-size: 12px;
            margin-top: 4px;
            text-align: left;
            display: block;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .password-input-wrapper {
            position: relative;
        }
        .password-toggle-icon {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #5f6368;
            font-size: 18px;
        }
        .password-toggle-icon:hover {
            color: #1a73e8;
        }
        .checkbox-container {
            display: flex;
            align-items: flex-start;
            margin-bottom: 24px;
            text-align: left;
        }
        .checkbox-container input[type="checkbox"] {
            margin-top: 2px;
            margin-right: 8px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }
        .checkbox-container label {
            font-size: 14px;
            color: #202124;
            line-height: 1.5;
            cursor: pointer;
        }
        .checkbox-container a {
            color: #1a73e8;
            text-decoration: none;
        }
        .checkbox-container a:hover {
            text-decoration: underline;
        }
        .login-link {
            color: #1a73e8;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
        }
        .login-link:hover {
            text-decoration: underline;
        }
        .button-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 32px;
        }
        .step-content {
            display: none;
        }
        .form-container {
            min-height: 300px;
            position: relative;
        }
        .step-content.active {
            display: block;
        }
        .date-select-group {
            display: flex;
            gap: 12px;
            margin-bottom: 8px;
        }
        .date-select {
            flex: 1;
            padding: 13px 15px;
            font-size: 16px;
            border: 1px solid #dadce0;
            border-radius: 4px;
            background-color: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
            cursor: pointer;
        }
        .date-select:focus {
            outline: none;
            border-color: #1a73e8;
            box-shadow: 0 0 0 1px #1a73e8;
        }
        .date-select-error {
            border-color: #ea4335;
        }
        .date-select-group .date-select:nth-child(1) {
            flex: 0 0 80px;
        }
        .date-select-group .date-select:nth-child(2) {
            flex: 0 0 120px;
        }
        .date-select-group .date-select:nth-child(3) {
            flex: 0 0 100px;
        }
    </style>

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
                // Combine first_name and last_name into name
                document.getElementById('name').value = this.formData.first_name + ' ' + this.formData.last_name;
                document.getElementById('first_name').value = this.formData.first_name;
                document.getElementById('last_name').value = this.formData.last_name;
                document.getElementById('email').value = this.formData.email;
                document.getElementById('password').value = this.formData.password;
                document.getElementById('password_confirmation').value = this.formData.password_confirmation;
                document.getElementById('phone').value = this.formData.phone;
                
                // Set referral_code if present
                if (this.formData.referral_code) {
                    const referralInput = document.getElementById('referral_code');
                    if (referralInput) referralInput.value = this.formData.referral_code;
                }
                
                // Set privacy_policy value (1 if checked, 0 if not)
                const privacyInput = document.getElementById('privacy_policy');
                if (privacyInput) {
                    privacyInput.value = this.formData.privacy_policy ? '1' : '0';
                }
                
                // Submit the form
                document.getElementById('register-form').submit();
            }
        },
        isStepCompleted(step) {
            if (step === 1) {
                return this.formData.first_name && this.formData.first_name.trim() !== '' && 
                       this.formData.last_name && this.formData.last_name.trim() !== '';
            } else if (step === 2) {
                return this.formData.email && /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.formData.email);
            } else if (step === 3) {
                return this.formData.password && this.formData.password.length >= 8 && 
                       this.formData.password_confirmation && this.formData.password === this.formData.password_confirmation;
            } else if (step === 4) {
                return this.formData.phone && this.formData.phone.trim() !== '' && this.formData.privacy_policy;
            }
            return false;
        }
    }">

        <!-- Google-style heading -->
        <h1 style="font-size: 24px; font-weight: 400; color: #202124; margin-bottom: 8px; text-align: left;">
            Konto erstellen
        </h1>
        <p style="font-size: 16px; color: #202124; margin-bottom: 32px; text-align: left;">
            In wenigen Schritten zu deinem persönlichen Konto
        </p>

        @if(isset($referrer_name))
        <!-- Empfohlen von Halit AK - Top Banner -->
        <div class="referral-banner">
            Empfohlen von {{ $referrer_name }}
        </div>
        @endif

        <form id="register-form" method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Hidden inputs for form submission -->
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
                <div class="form-group">
                    <label for="first_name_input" class="google-label">Vorname</label>
                    <input id="first_name_input" 
                           class="google-input"
                           :class="{ 'google-input-error': errors.first_name }"
                           type="text" 
                           x-model="formData.first_name"
                           required 
                           autofocus 
                           autocomplete="given-name" />
                    <span x-show="errors.first_name" class="error-message" x-text="errors.first_name"></span>
                </div>

                <div class="form-group">
                    <label for="last_name_input" class="google-label">Nachname</label>
                    <input id="last_name_input" 
                           class="google-input"
                           :class="{ 'google-input-error': errors.last_name }"
                           type="text" 
                           x-model="formData.last_name"
                           required 
                           autocomplete="family-name" />
                    <span x-show="errors.last_name" class="error-message" x-text="errors.last_name"></span>
                </div>

                <div class="button-group">
                    <a href="{{ route('login') }}" class="login-link">
                        Bereits registriert?
                    </a>
                    <button type="button" @click="nextStep()" class="google-button">
                        Weiter
                    </button>
                </div>
            </div>

            <!-- Step 2: Email -->
            <div class="step-content" :class="{ 'active': currentStep === 2 }" x-show="currentStep === 2">
                <div class="form-group">
                    <label for="email_input" class="google-label">E-Mail-Adresse</label>
                    <input id="email_input" 
                           class="google-input"
                           :class="{ 'google-input-error': errors.email }"
                           type="email" 
                           x-model="formData.email"
                           required 
                           autocomplete="username" />
                    <span x-show="errors.email" class="error-message" x-text="errors.email"></span>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
        </div>

                <div class="button-group">
                    <button type="button" @click="prevStep()" class="google-button-secondary">
                        Zurück
                    </button>
                    <button type="button" @click="nextStep()" class="google-button">
                        Weiter
                    </button>
                </div>
            </div>

            <!-- Step 3: Password -->
            <div class="step-content" :class="{ 'active': currentStep === 3 }" x-show="currentStep === 3">
                <div class="form-group">
                    <label for="password_input" class="google-label">Passwort</label>
                    <div class="password-input-wrapper">
                        <input id="password_input" 
                               class="google-input"
                               :class="{ 'google-input-error': errors.password }"
                               :type="showPassword ? 'text' : 'password'"
                               x-model="formData.password"
                               required 
                               autocomplete="new-password" />
                        <i class="password-toggle-icon fa-solid" 
                           :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"
                           @click="showPassword = !showPassword"></i>
                    </div>
                    <span x-show="errors.password" class="error-message" x-text="errors.password"></span>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
        </div>

                <div class="form-group">
                    <label for="password_confirmation_input" class="google-label">Passwort bestätigen</label>
                    <input id="password_confirmation_input" 
                           class="google-input"
                           :class="{ 'google-input-error': errors.password_confirmation }"
                           type="password"
                           x-model="formData.password_confirmation" 
                           required 
                           autocomplete="new-password" />
                    <span x-show="errors.password_confirmation" class="error-message" x-text="errors.password_confirmation"></span>
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="button-group">
                    <button type="button" @click="prevStep()" class="google-button-secondary">
                        Zurück
                    </button>
                    <button type="button" @click="nextStep()" class="google-button">
                        Weiter
                    </button>
                </div>
            </div>

            <!-- Step 4: Phone, Privacy Policy and Submit -->
            <div class="step-content" :class="{ 'active': currentStep === 4 }" x-show="currentStep === 4">
                <div class="form-group">
                    <label for="phone_input" class="google-label">Telefonnummer</label>
                    <input id="phone_input" 
                           class="google-input"
                           :class="{ 'google-input-error': errors.phone }"
                           type="tel" 
                           x-model="formData.phone"
                           required 
                           autocomplete="tel" />
                    <span x-show="errors.phone" class="error-message" x-text="errors.phone"></span>
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="checkbox-container">
                    <input id="privacy_policy_input" 
                           type="checkbox" 
                           x-model="formData.privacy_policy"
                           required 
                           value="1">
                    <label for="privacy_policy_input">
                        Ich akzeptiere die <a target="_blank" href="{{ route('datenschutz') }}" onclick="event.stopPropagation();">Datenschutzerklärung</a>
                    </label>
                </div>
                <span x-show="errors.privacy_policy" class="error-message" x-text="errors.privacy_policy"></span>
                @error('privacy_policy')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <div class="button-group">
                    <button type="button" @click="prevStep()" class="google-button-secondary">
                        Zurück
                    </button>
                    <button type="button" @click="submitForm()" class="google-button">
                        Registrieren
                    </button>
                </div>
            </div>
        </div>
    </form>
    </div>

    <x-slot name="footer">
        <div class="flex flex-col items-center relative pb-12 w-full mx-auto" style="margin-top: 10px;">
            <!-- Cloud Speech Bubble (CSS/SVG Path) -->
            <div class="relative w-full z-50">
               <div class="bg-white p-4 pt-5 pb-8 shadow-sm relative visible w-full" style="border-radius: 50px;">
                   <!-- Cloud Circles for irregular shape -->
                   <div class="absolute -top-3 left-4 w-10 h-10 bg-white rounded-full"></div>
                   <div class="absolute -top-5 left-10 w-14 h-14 bg-white rounded-full"></div>
                   <div class="absolute -top-3 right-8 w-10 h-10 bg-white rounded-full"></div>
                   <div class="absolute -right-3 top-2 w-10 h-10 bg-white rounded-full"></div>
                   <div class="absolute -left-3 top-2 w-8 h-8 bg-white rounded-full"></div>
                   
                   <p class="text-gray-600 text-[10px] text-center leading-relaxed relative z-20 font-medium whitespace-normal">
                       ⚡ Dein Strom ist zu teuer? ⚡<br>
                       Wir optimieren deine Kosten – komplett kostenlos! Zusätzlich bringt dich jede erfolgreiche Empfehlung einem Gesamtgutscheinwert von bis zu 315€ näher.
                   </p>
               </div>
            </div>
           
           <!-- Kush Bird -->
            <div class="z-10 mt-2">
               <img src="{{ asset('assets/kush.png') }}" alt="Kush" class="w-14 h-auto transform scale-100 origin-bottom drop-shadow-md" style="width: 280px;">
            </div>
       </div>
    </x-slot>
</x-guest-layout>
