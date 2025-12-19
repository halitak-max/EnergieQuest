<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Passwort ändern') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Stellen Sie sicher, dass Ihr Konto ein langes, zufälliges Passwort verwendet, um sicher zu bleiben.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="current_password" :value="__('Aktuelles Passwort')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full text-center" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Neues Passwort')" />
            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full text-center" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Passwort bestätigen')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full text-center" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center gap-4">
            <x-primary-button>{{ __('Speichern') }}</x-primary-button>

            @if (session('status') === 'password-updated')
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
</section>
