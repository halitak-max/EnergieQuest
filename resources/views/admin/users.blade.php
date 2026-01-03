<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EnergieQuest') }} Admin - Alle User</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen">
            @include('admin.partials.navigation')

            <main class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="font-bold text-lg mb-4">Alle User</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">E-Mail</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Telefon</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Geburtsdatum</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">IBAN</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Profilsperre</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Empfehlungscode</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">E-Mail verifiziert</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Registriert am</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Aktion</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($users as $user)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->phone ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    @if($user->birth_date)
                                                        {{ \Carbon\Carbon::parse($user->birth_date)->format('d.m.Y') }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->iban ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <div class="flex gap-2">
                                                        <button 
                                                            type="button"
                                                            class="profile-lock-btn px-2 py-1 text-xs font-semibold rounded-full hover:opacity-80 focus:outline-none cursor-pointer"
                                                            style="{{ $user->offer_accepted ? 'background-color: #D1FAE5 !important; color: #15803D !important;' : 'background-color: #F3F4F6 !important; color: #9CA3AF !important;' }}"
                                                            data-user-id="{{ $user->id }}"
                                                            onclick="toggleProfileLock({{ $user->id }}, true)"
                                                        >
                                                            Ja
                                                        </button>
                                                        <button 
                                                            type="button"
                                                            class="profile-lock-btn px-2 py-1 text-xs font-semibold rounded-full hover:opacity-80 focus:outline-none cursor-pointer"
                                                            style="{{ !$user->offer_accepted ? 'background-color: #FEE2E2 !important; color: #991B1B !important;' : 'background-color: #F3F4F6 !important; color: #9CA3AF !important;' }}"
                                                            data-user-id="{{ $user->id }}"
                                                            onclick="toggleProfileLock({{ $user->id }}, false)"
                                                        >
                                                            Nein
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->referral_code ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    @if($user->email_verified_at)
                                                        <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Ja</span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Nein</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <button
                                                        type="button"
                                                        class="eka-btn inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-black hover:opacity-80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-300"
                                                        style="background-color: #87CEEB;"
                                                        data-user-id="{{ $user->id }}"
                                                        onclick="openUserEkaModal({{ $user->id }})"
                                                    >
                                                        EKA
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="px-6 py-4 text-center text-sm text-gray-500">Keine User vorhanden</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>

        @include('admin.partials.eka-modal')
        @include('admin.partials.eka-scripts')

        <script>
            function toggleProfileLock(userId, locked) {
                fetch(`/admin/users/${userId}/profile-lock`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ locked: locked })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Fehler beim Aktualisieren des Profil-Status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Fehler beim Aktualisieren des Profil-Status');
                });
            }
        </script>
    </body>
</html>

