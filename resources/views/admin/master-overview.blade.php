<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EnergieQuest') }} Admin - Master-Übersicht</title>
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
                            <h3 class="font-bold text-lg mb-4">Master-Übersicht (Alle Daten kombiniert)</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">User ID</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">E-Mail</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Telefon</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">IBAN</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Geburtsdatum</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Profilsperre</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Uploads</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Termine</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Referrals</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">E-Mail Verifiziert</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Registriert</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Aktionen</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($users as $user)
                                            @php
                                                $userUploads = $uploads->where('user_id', $user->id);
                                                $userAppointments = $appointments->where('user_id', $user->id);
                                                $userReferralsAsReferrer = $referrals->where('referrer_id', $user->id);
                                                $userReferralsAsReferred = $referrals->where('referred_user_id', $user->id);
                                            @endphp
                                            <tr>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $user->name }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->phone ?? '-' }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->iban ?? '-' }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d.m.Y') : '-' }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm">
                                                    <div class="flex gap-2">
                                                        <button 
                                                            type="button"
                                                            class="profile-lock-btn px-2 py-1 text-xs font-semibold rounded-full hover:opacity-80 focus:outline-none cursor-pointer"
                                                            style="{{ $user->offer_accepted ? 'background-color: #D1FAE5 !important; color: #15803D !important;' : 'background-color: #F3F4F6 !important; color: #9CA3AF !important;' }}"
                                                            onclick="toggleProfileLock({{ $user->id }}, true)"
                                                        >
                                                            Ja
                                                        </button>
                                                        <button 
                                                            type="button"
                                                            class="profile-lock-btn px-2 py-1 text-xs font-semibold rounded-full hover:opacity-80 focus:outline-none cursor-pointer"
                                                            style="{{ !$user->offer_accepted ? 'background-color: #FEE2E2 !important; color: #991B1B !important;' : 'background-color: #F3F4F6 !important; color: #9CA3AF !important;' }}"
                                                            onclick="toggleProfileLock({{ $user->id }}, false)"
                                                        >
                                                            Nein
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-sm text-gray-900">
                                                    @if($userUploads->count() > 0)
                                                        <div class="space-y-1">
                                                            @foreach($userUploads as $upload)
                                                                <div class="text-xs">
                                                                    <div class="flex items-center gap-2">
                                                                        <span>{{ $upload->original_name }}</span>
                                                                        @if(Storage::disk('public')->exists($upload->file_path))
                                                                            <a href="{{ Storage::disk('public')->url($upload->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-xs">
                                                                                <i class="fa-solid fa-external-link"></i>
                                                                            </a>
                                                                        @else
                                                                            <span class="text-red-500 text-xs">Nicht gefunden</span>
                                                                        @endif
                                                                    </div>
                                                                    <span class="text-xs text-gray-500">{{ $upload->created_at->format('d.m.Y H:i') }}</span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-4 text-sm text-gray-900">
                                                    @if($userAppointments->count() > 0)
                                                        <div class="space-y-1">
                                                            @foreach($userAppointments as $appointment)
                                                                <div class="text-xs">
                                                                    <div>{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y') }} {{ $appointment->appointment_time }}</div>
                                                                    @if($appointment->status === 'pending')
                                                                        <span class="px-1 py-0.5 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded">Ausstehend</span>
                                                                    @elseif($appointment->status === 'confirmed')
                                                                        <span class="px-1 py-0.5 text-xs font-semibold text-green-700 bg-green-100 rounded">Bestätigt</span>
                                                                    @elseif($appointment->status === 'cancelled')
                                                                        <span class="px-1 py-0.5 text-xs font-semibold text-red-700 bg-red-100 rounded">Abgesagt</span>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <span class="text-gray-400">-</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-4 text-sm text-gray-900">
                                                    <div class="space-y-1">
                                                        @if($userReferralsAsReferrer->count() > 0)
                                                            <div class="text-xs">
                                                                <span class="font-semibold">Als Werber:</span>
                                                                @foreach($userReferralsAsReferrer as $ref)
                                                                    <div class="ml-2">
                                                                        <select 
                                                                            class="referral-status-select border-gray-300 rounded text-xs ml-1"
                                                                            data-referral-id="{{ $ref->id }}"
                                                                            data-current-status="{{ $ref->status }}"
                                                                            id="master-status-select-{{ $ref->id }}"
                                                                            onchange="saveReferralStatus({{ $ref->id }})"
                                                                        >
                                                                            <option value="0" {{ $ref->status == 0 ? 'selected' : '' }}>0</option>
                                                                            <option value="1" {{ $ref->status == 1 ? 'selected' : '' }}>1</option>
                                                                            <option value="2" {{ $ref->status == 2 ? 'selected' : '' }}>2</option>
                                                                        </select>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        @if($userReferralsAsReferred->count() > 0)
                                                            <div class="text-xs mt-1">
                                                                <span class="font-semibold">Als Geworbener:</span>
                                                                @foreach($userReferralsAsReferred as $ref)
                                                                    <div class="ml-2">
                                                                        <select 
                                                                            class="referral-status-select border-gray-300 rounded text-xs ml-1"
                                                                            data-referral-id="{{ $ref->id }}"
                                                                            data-current-status="{{ $ref->status }}"
                                                                            id="master-status-select-{{ $ref->id }}"
                                                                            onchange="saveReferralStatus({{ $ref->id }})"
                                                                        >
                                                                            <option value="0" {{ $ref->status == 0 ? 'selected' : '' }}>0</option>
                                                                            <option value="1" {{ $ref->status == 1 ? 'selected' : '' }}>1</option>
                                                                            <option value="2" {{ $ref->status == 2 ? 'selected' : '' }}>2</option>
                                                                        </select>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                        @if($userReferralsAsReferrer->count() == 0 && $userReferralsAsReferred->count() == 0)
                                                            <span class="text-gray-400">-</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm">
                                                    @if($user->email_verified_at)
                                                        <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Ja</span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Nein</span>
                                                    @endif
                                                </td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm">
                                                    <button
                                                        type="button"
                                                        class="eka-btn inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-black hover:opacity-80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-300"
                                                        style="background-color: #87CEEB;"
                                                        onclick="openUserEkaModal({{ $user->id }})"
                                                    >
                                                        EKA
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="13" class="px-4 py-4 text-center text-sm text-gray-500">Keine User vorhanden</td>
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
            function saveReferralStatus(referralId) {
                const select = document.getElementById(`master-status-select-${referralId}`);
                const newStatus = select.value;
                const originalStatus = select.dataset.currentStatus;
                
                select.disabled = true;
                
                fetch(`/admin/referrals/${referralId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        select.dataset.currentStatus = newStatus;
                    } else {
                        throw new Error('Update failed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    select.value = originalStatus;
                    alert('Fehler beim Speichern des Status');
                })
                .finally(() => {
                    select.disabled = false;
                });
            }

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

