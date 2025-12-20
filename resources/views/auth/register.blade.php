<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="text-center">
            <x-input-label for="name" :value="__('Vollständiger Name')" />
            <x-text-input id="name" class="block mt-1 w-full text-center" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4 text-center">
            <x-input-label for="email" :value="__('E-Mail')" />
            <x-text-input id="email" class="block mt-1 w-full text-center" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4 text-center">
            <x-input-label for="phone" :value="__('Telefonnummer')" />
            <x-text-input id="phone" class="block mt-1 w-full text-center" type="text" name="phone" :value="old('phone')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 text-center">
            <x-input-label for="password" :value="__('Passwort')" />

            <x-text-input id="password" class="block mt-1 w-full text-center"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4 text-center">
            <x-input-label for="password_confirmation" :value="__('Passwort bestätigen')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full text-center"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Referral Code -->
        <div class="mt-4 text-center">
            @if(isset($referrer_name))
                <x-input-label for="referral_code" :value="__('Empfohlen von')" />
                <div class="block mt-1 w-full text-center py-2 bg-gray-100 rounded-md border border-gray-300 text-gray-700 font-medium">
                    {{ $referrer_name }}
                </div>
                <input type="hidden" name="referral_code" value="{{ $referral_code }}">
            @else
                <x-input-label for="referral_code" :value="__('Empfehlungscode (Optional)')" />
                <x-text-input id="referral_code" class="block mt-1 w-full text-center" type="text" name="referral_code" :value="old('referral_code', $referral_code ?? request('ref'))" />
            @endif
            <x-input-error :messages="$errors->get('referral_code')" class="mt-2" />
        </div>

        <!-- Privacy Policy Checkbox -->
        <div class="mt-4 block text-center">
            <label for="privacy_policy" class="inline-flex items-center justify-center w-full">
                <input id="privacy_policy" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="privacy_policy" required>
                <span class="ml-2 text-sm text-gray-600">{{ __('Ich akzeptiere die') }} <a target="_blank" href="{{ route('datenschutz') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Datenschutzerklärung') }}</a></span>
            </label>
            <x-input-error :messages="$errors->get('privacy_policy')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-center mt-4 w-full">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Bereits registriert?') }}
            </a>

            <x-primary-button class="mt-4 w-full justify-center">
                {{ __('Registrieren') }}
            </x-primary-button>
        </div>
    </form>

    <x-slot name="footer">
        <div class="flex flex-col items-center relative pb-12 w-full mx-auto" style="margin-top: 10px; max-width: 280px;">
            <!-- Cloud Speech Bubble (CSS/SVG Path) -->
            <div class="relative w-full z-50">
               <div class="bg-white p-4 pt-5 pb-8 shadow-sm relative visible w-full" style="border-radius: 50px;">
                   <!-- Cloud Circles for irregular shape -->
                   <div class="absolute -top-3 left-4 w-10 h-10 bg-white rounded-full"></div>
                   <div class="absolute -top-5 left-10 w-14 h-14 bg-white rounded-full"></div>
                   <div class="absolute -top-3 right-8 w-10 h-10 bg-white rounded-full"></div>
                   <div class="absolute -right-3 top-2 w-10 h-10 bg-white rounded-full"></div>
                   <div class="absolute -left-3 top-2 w-8 h-8 bg-white rounded-full"></div>
                   
                   <p class="text-gray-600 text-[10px] text-center leading-relaxed relative z-20 font-normal whitespace-normal">
                       💸 Schluss mit zu teurem Strom! 💸<br>
                       Wir optimieren deinen Tarif und belohnen dich dafür.<br>
                       Lade deine Rechnung hoch, sammle Punkte und kassiere Gutscheine!
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
