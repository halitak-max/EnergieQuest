<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EnergieQuest') }} Admin</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.svg') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.svg') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            function saveReferralStatus(referralId) {
                const select = document.getElementById(`master-status-select-${referralId}`);
                const newStatus = select.value;
                const originalStatus = select.dataset.currentStatus;
                
                // Disable select while saving
                select.disabled = true;
                
                // Send AJAX request
                fetch(`/admin/referrals/${referralId}/status`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
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
                    // Revert to original status
                    select.value = originalStatus;
                    alert('Fehler beim Speichern des Status');
                })
                .finally(() => {
                    select.disabled = false;
                });
            }
            
            document.addEventListener('DOMContentLoaded', function() {
                const saveButtons = document.querySelectorAll('.save-status-btn');
                
                saveButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const referralId = this.dataset.referralId;
                        const select = document.getElementById(`status-select-${referralId}`);
                        const indicator = document.getElementById(`status-indicator-${referralId}`);
                        const newStatus = select.value;
                        const originalStatus = select.dataset.currentStatus;
                        
                        // Disable button and select while saving
                        this.disabled = true;
                        select.disabled = true;
                        indicator.textContent = 'Speichere...';
                        indicator.className = 'status-indicator ml-2 text-xs text-blue-600';
                        
                        // Send AJAX request
                        fetch(`/admin/referrals/${referralId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                status: newStatus
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                indicator.textContent = '✓ Gespeichert';
                                indicator.className = 'status-indicator ml-2 text-xs text-green-600';
                                select.dataset.currentStatus = newStatus;
                                
                                // Remove success message after 2 seconds
                                setTimeout(() => {
                                    indicator.textContent = '';
                                }, 2000);
                            } else {
                                throw new Error('Update failed');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            indicator.textContent = '✗ Fehler';
                            indicator.className = 'status-indicator ml-2 text-xs text-red-600';
                            // Revert to original status
                            select.value = originalStatus;
                            
                            setTimeout(() => {
                                indicator.textContent = '';
                            }, 3000);
                        })
                        .finally(() => {
                            this.disabled = false;
                            select.disabled = false;
                        });
                    });
                });
            });
        </script>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen">
            <!-- Navigation -->
            <nav class="bg-white border-b border-gray-100">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <x-energiequest-logo />
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                                    Dashboard
                                </a>
                            </div>
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <div class="relative">
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        {{ Auth::guard('admin')->user()->name }} (Logout)
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                    
                    <!-- Combined Master Table -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="font-bold text-lg mb-4">Master-Übersicht (Alle Daten kombiniert)</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-Mail</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefon</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profilsperre</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploads</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Termine</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referrals</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-Mail Verifiziert</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registriert</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktionen</th>
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
                                                <td class="px-4 py-4 whitespace-nowrap text-sm">
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
                                                <td class="px-4 py-4 text-sm text-gray-900">
                                                    @if($userUploads->count() > 0)
                                                        <div class="space-y-1">
                                                            @foreach($userUploads as $upload)
                                                                <div class="flex items-center gap-2">
                                                                    <span class="text-xs">{{ $upload->original_name }}</span>
                                                                    <a href="{{ Storage::disk('public')->url($upload->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 text-xs">
                                                                        <i class="fa-solid fa-external-link"></i>
                                                                    </a>
                                                                </div>
                                                                <span class="text-xs text-gray-500">{{ $upload->created_at->format('d.m.Y H:i') }}</span>
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
                                                                        <span>{{ $ref->referredUser->name ?? 'N/A' }}</span>
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
                                                                    <div class="ml-2">{{ $ref->referrer->name ?? 'N/A' }}</div>
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
                                                        data-user-id="{{ $user->id }}"
                                                        onclick="openUserEkaModal({{ $user->id }})"
                                                    >
                                                        EKA
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="11" class="px-4 py-4 text-center text-sm text-gray-500">Keine User vorhanden</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Uploads Table -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="font-bold text-lg mb-4">Alle Uploads</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dateiname</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktion</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($uploads as $upload)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $upload->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $upload->user->name }}<br>
                                                    <span class="text-xs text-gray-500">{{ $upload->user->email }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $upload->original_name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $upload->created_at->format('d.m.Y H:i') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ Storage::disk('public')->url($upload->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                                        Anzeigen
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Keine Uploads vorhanden</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Referrals Table -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="font-bold text-lg mb-4">Alle Referrals</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Werber</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Geworbener User</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($referrals as $referral)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $referral->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $referral->referrer->name }}<br>
                                                    <span class="text-xs text-gray-500">{{ $referral->referrer->email }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $referral->referredUser->name }}<br>
                                                    <span class="text-xs text-gray-500">{{ $referral->referredUser->email }}</span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <select 
                                                        class="referral-status-select border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                                        data-referral-id="{{ $referral->id }}"
                                                        data-current-status="{{ $referral->status }}"
                                                        id="status-select-{{ $referral->id }}"
                                                    >
                                                        <option value="0" {{ $referral->status == 0 ? 'selected' : '' }}>0</option>
                                                        <option value="1" {{ $referral->status == 1 ? 'selected' : '' }}>1</option>
                                                        <option value="2" {{ $referral->status == 2 ? 'selected' : '' }}>2</option>
                                                    </select>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $referral->created_at->format('d.m.Y H:i') }}
                                                    <button 
                                                        type="button"
                                                        class="save-status-btn ml-2 inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-black bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                                        data-referral-id="{{ $referral->id }}"
                                                    >
                                                        Speichern
                                                    </button>
                                                    <span class="status-indicator ml-2 text-xs" id="status-indicator-{{ $referral->id }}"></span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Keine Referrals vorhanden</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Appointments Table -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="font-bold text-lg mb-4">Termine</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-Mail</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefon</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uhrzeit</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Erstellt am</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($appointments as $appointment)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->id }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->user->name ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->user->email ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->user->phone ?? '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d.m.Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $appointment->appointment_time }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    @if($appointment->status === 'pending')
                                                        <span class="px-2 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">Ausstehend</span>
                                                    @elseif($appointment->status === 'confirmed')
                                                        <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">Bestätigt</span>
                                                    @elseif($appointment->status === 'cancelled')
                                                        <span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">Abgesagt</span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">{{ $appointment->status }}</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $appointment->created_at->format('d.m.Y H:i') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Keine Termine vorhanden</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Users Table -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="font-bold text-lg mb-4">Alle User</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-Mail</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefon</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Geburtsdatum</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IBAN</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profilsperre</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empfehlungscode</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-Mail verifiziert</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registriert am</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktion</th>
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
                                                            data-locked="true"
                                                            onclick="toggleProfileLock({{ $user->id }}, true)"
                                                        >
                                                            Ja
                                                        </button>
                                                        <button 
                                                            type="button"
                                                            class="profile-lock-btn px-2 py-1 text-xs font-semibold rounded-full hover:opacity-80 focus:outline-none cursor-pointer"
                                                            style="{{ !$user->offer_accepted ? 'background-color: #FEE2E2 !important; color: #991B1B !important;' : 'background-color: #F3F4F6 !important; color: #9CA3AF !important;' }}"
                                                            data-user-id="{{ $user->id }}"
                                                            data-locked="false"
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

        <!-- EKA Modal -->
        <div id="ekaModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
            <div class="relative top-8 mx-auto p-5 border w-11/12 max-w-6xl shadow-lg rounded-md bg-white flex flex-col max-h-[calc(100vh-4rem)]">
                <div class="flex-shrink-0">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Energiekostenanalyse</h3>
                        <button onclick="closeEkaModal()" class="text-gray-400 hover:text-gray-600">
                            <span class="text-2xl">&times;</span>
                        </button>
                    </div>
                </div>
                
                <div class="flex-1 overflow-y-auto">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Ihr aktueller Anbieter -->
                        <div class="border rounded-lg p-4">
                            <h4 class="font-bold text-sm mb-3">Ihr aktueller Anbieter</h4>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Anbieter Name</label>
                                    <input type="text" id="current-provider" class="w-full border rounded px-2 py-1 text-xs">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Tarif</label>
                                    <input type="text" id="current-tariff" class="w-full border rounded px-2 py-1 text-xs">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">PLZ/Ort</label>
                                    <input type="text" id="current-location" class="w-full border rounded px-2 py-1 text-xs" onchange="copyToNewProvider('location')">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Verbrauch/Jahr (kWh)</label>
                                    <input type="number" id="current-consumption" class="w-full border rounded px-2 py-1 text-xs" onchange="calculateCurrentCosts(); copyToNewProvider('consumption');">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Anzahl Monate</label>
                                    <input type="number" id="current-months" class="w-full border rounded px-2 py-1 text-xs" value="12" onchange="calculateCurrentCosts(); copyToNewProvider('months');">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Arbeitspreis (Ct./kWh)</label>
                                    <input type="number" step="0.01" id="current-working-price" class="w-full border rounded px-2 py-1 text-xs" onchange="calculateCurrentCosts()">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Grundpreis/Monat (EUR)</label>
                                    <input type="number" step="0.01" id="current-basic-price" class="w-full border rounded px-2 py-1 text-xs" onchange="calculateCurrentCosts()">
                                </div>
                                <div class="pt-2 border-t">
                                    <div class="text-xs">
                                        <div class="flex justify-between mb-1">
                                            <span>Gesamtkosten EUR (Verbrauch):</span>
                                            <span id="current-consumption-cost">0.00</span>
                                        </div>
                                        <div class="flex justify-between mb-1">
                                            <span>Grundpreis/Jahr EUR:</span>
                                            <span id="current-basic-year">0.00</span>
                                        </div>
                                        <div class="flex justify-between font-bold">
                                            <span>Gesamtkosten EUR:</span>
                                            <span id="current-total">0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ihr neuer Anbieter -->
                        <div class="border rounded-lg p-4">
                            <h4 class="font-bold text-sm mb-3">Ihr neuer Anbieter</h4>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Anbieter Name</label>
                                    <input type="text" id="new-provider" class="w-full border rounded px-2 py-1 text-xs">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Tarif</label>
                                    <input type="text" id="new-tariff" class="w-full border rounded px-2 py-1 text-xs">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">PLZ/Ort</label>
                                    <input type="text" id="new-location" class="w-full border rounded px-2 py-1 text-xs">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Verbrauch/Jahr (kWh)</label>
                                    <input type="number" id="new-consumption" class="w-full border rounded px-2 py-1 text-xs" onchange="calculateNewCosts()">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Anzahl Monate</label>
                                    <input type="number" id="new-months" class="w-full border rounded px-2 py-1 text-xs" value="12" onchange="calculateNewCosts()">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Arbeitspreis (Ct./kWh)</label>
                                    <input type="number" step="0.01" id="new-working-price" class="w-full border rounded px-2 py-1 text-xs" onchange="calculateNewCosts()">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Grundpreis/Monat (EUR)</label>
                                    <input type="number" step="0.01" id="new-basic-price" class="w-full border rounded px-2 py-1 text-xs" onchange="calculateNewCosts()">
                                </div>
                                <div class="pt-2 border-t">
                                    <div class="text-xs">
                                        <div class="flex justify-between mb-1">
                                            <span>Gesamtkosten EUR (Verbrauch):</span>
                                            <span id="new-consumption-cost">0.00</span>
                                        </div>
                                        <div class="flex justify-between mb-1">
                                            <span>Grundpreis/Jahr EUR:</span>
                                            <span id="new-basic-year">0.00</span>
                                        </div>
                                        <div class="flex justify-between font-bold">
                                            <span>Gesamtkosten EUR:</span>
                                            <span id="new-total">0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ihre Ersparnis -->
                        <div class="border rounded-lg p-4">
                            <h4 class="font-bold text-sm mb-3">Ihre Ersparnis</h4>
                            <div class="space-y-2 text-sm">
                                <div class="pt-2 border-t">
                                    <div class="text-xs space-y-2">
                                        <div>
                                            <div class="flex justify-between mb-1">
                                                <span>Aktueller Anbieter Gesamtkosten:</span>
                                                <span id="savings-current-total">0.00 EUR</span>
                                            </div>
                                            <div class="flex justify-between mb-1">
                                                <span>Neuer Anbieter Gesamtkosten:</span>
                                                <span id="savings-new-total">0.00 EUR</span>
                                            </div>
                                        </div>
                                        <div class="pt-2 border-t">
                                            <div class="mb-2">
                                                <div class="font-semibold mb-1">Ersparnis Jahr 1:</div>
                                                <div class="flex justify-between">
                                                    <span>EUR:</span>
                                                    <span id="savings-year1-eur">0.00</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span>%:</span>
                                                    <span id="savings-year1-percent">0.0</span>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <div class="font-semibold mb-1">Ersparnis Jahr 2:</div>
                                                <div class="flex justify-between">
                                                    <span>EUR:</span>
                                                    <span id="savings-year2-eur">0.00</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span>%:</span>
                                                    <span id="savings-year2-percent">0.0</span>
                                                </div>
                                            </div>
                                            <div class="pt-2 border-t">
                                                <div class="font-semibold mb-1">Maximale Ersparnis:</div>
                                                <div class="flex justify-between">
                                                    <span>EUR:</span>
                                                    <span id="savings-max-eur">0.00</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span>%:</span>
                                                    <span id="savings-max-percent">0.0</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex-shrink-0 mt-6 pt-4 border-t bg-white flex justify-end gap-3 sticky bottom-0">
                    <button onclick="closeEkaModal()" class="px-6 py-2.5 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 text-sm font-medium transition">
                        Schließen
                    </button>
                    <button onclick="saveEkaData()" class="px-6 py-2.5 bg-indigo-600 text-black rounded hover:bg-indigo-700 text-sm font-medium transition shadow-md">
                        Speichern
                    </button>
                </div>
            </div>
        </div>

        <script>
            function openEkaModal(referralId) {
                document.getElementById('ekaModal').classList.remove('hidden');
                document.getElementById('ekaModal').dataset.referralId = referralId;
                document.getElementById('ekaModal').dataset.type = 'referral';
                loadEkaData('referral', referralId);
            }

            function openUserEkaModal(userId) {
                document.getElementById('ekaModal').classList.remove('hidden');
                document.getElementById('ekaModal').dataset.userId = userId;
                document.getElementById('ekaModal').dataset.type = 'user';
                loadEkaData('user', userId);
            }

            function loadEkaData(type, id) {
                const url = type === 'user' ? `/admin/users/${id}/eka` : `/admin/referrals/${id}/eka`;
                
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Fill current provider fields
                    document.getElementById('current-provider').value = data.current_provider || '';
                    document.getElementById('current-tariff').value = data.current_tariff || '';
                    document.getElementById('current-location').value = data.current_location || '';
                    document.getElementById('current-consumption').value = data.current_consumption || '';
                    document.getElementById('current-months').value = data.current_months || '12';
                    document.getElementById('current-working-price').value = data.current_working_price || '';
                    document.getElementById('current-basic-price').value = data.current_basic_price || '';
                    
                    // Fill new provider fields
                    document.getElementById('new-provider').value = data.new_provider || '';
                    document.getElementById('new-tariff').value = data.new_tariff || '';
                    document.getElementById('new-location').value = data.new_location || '';
                    document.getElementById('new-consumption').value = data.new_consumption || '';
                    document.getElementById('new-months').value = data.new_months || '12';
                    document.getElementById('new-working-price').value = data.new_working_price || '';
                    document.getElementById('new-basic-price').value = data.new_basic_price || '';
                    
                    // Recalculate and display
                    calculateCurrentCosts();
                    calculateNewCosts();
                    calculateSavings();
                })
                .catch(error => {
                    console.error('Error loading EKA data:', error);
                });
            }

            function closeEkaModal() {
                document.getElementById('ekaModal').classList.add('hidden');
                // Clear data attributes
                delete document.getElementById('ekaModal').dataset.referralId;
                delete document.getElementById('ekaModal').dataset.userId;
                delete document.getElementById('ekaModal').dataset.type;
            }

            function copyToNewProvider(field) {
                if (field === 'location') {
                    const currentValue = document.getElementById('current-location').value;
                    document.getElementById('new-location').value = currentValue;
                } else if (field === 'consumption') {
                    const currentValue = document.getElementById('current-consumption').value;
                    document.getElementById('new-consumption').value = currentValue;
                    calculateNewCosts();
                } else if (field === 'months') {
                    const currentValue = document.getElementById('current-months').value;
                    document.getElementById('new-months').value = currentValue;
                    calculateNewCosts();
                }
            }

            function calculateCurrentCosts() {
                const consumption = parseFloat(document.getElementById('current-consumption').value) || 0;
                const workingPrice = parseFloat(document.getElementById('current-working-price').value) || 0;
                const basicPrice = parseFloat(document.getElementById('current-basic-price').value) || 0;
                const months = parseFloat(document.getElementById('current-months').value) || 12;

                const consumptionCost = (consumption * workingPrice) / 100;
                const basicYear = basicPrice * months;
                const total = consumptionCost + basicYear;

                document.getElementById('current-consumption-cost').textContent = consumptionCost.toFixed(2);
                document.getElementById('current-basic-year').textContent = basicYear.toFixed(2);
                document.getElementById('current-total').textContent = total.toFixed(2);

                calculateSavings();
            }

            function calculateNewCosts() {
                const consumption = parseFloat(document.getElementById('new-consumption').value) || 0;
                const workingPrice = parseFloat(document.getElementById('new-working-price').value) || 0;
                const basicPrice = parseFloat(document.getElementById('new-basic-price').value) || 0;
                const months = parseFloat(document.getElementById('new-months').value) || 12;

                const consumptionCost = (consumption * workingPrice) / 100;
                const basicYear = basicPrice * months;
                const total = consumptionCost + basicYear;

                document.getElementById('new-consumption-cost').textContent = consumptionCost.toFixed(2);
                document.getElementById('new-basic-year').textContent = basicYear.toFixed(2);
                document.getElementById('new-total').textContent = total.toFixed(2);

                calculateSavings();
            }

            function calculateSavings() {
                const currentTotal = parseFloat(document.getElementById('current-total').textContent) || 0;
                const newTotal = parseFloat(document.getElementById('new-total').textContent) || 0;

                document.getElementById('savings-current-total').textContent = currentTotal.toFixed(2) + ' EUR';
                document.getElementById('savings-new-total').textContent = newTotal.toFixed(2) + ' EUR';

                const savingsYear1 = currentTotal - newTotal;
                const savingsPercent = currentTotal > 0 ? ((savingsYear1 / currentTotal) * 100) : 0;
                const savingsYear2 = savingsYear1;
                const savingsMax = savingsYear1 * 2;

                document.getElementById('savings-year1-eur').textContent = savingsYear1.toFixed(2);
                document.getElementById('savings-year1-percent').textContent = savingsPercent.toFixed(1);
                document.getElementById('savings-year2-eur').textContent = savingsYear2.toFixed(2);
                document.getElementById('savings-year2-percent').textContent = savingsPercent.toFixed(1);
                document.getElementById('savings-max-eur').textContent = savingsMax.toFixed(2);
                document.getElementById('savings-max-percent').textContent = savingsPercent.toFixed(1);
            }

            function saveEkaData() {
                const modal = document.getElementById('ekaModal');
                const type = modal.dataset.type;
                const referralId = modal.dataset.referralId;
                const userId = modal.dataset.userId;
                
                // Calculate totals before saving
                calculateCurrentCosts();
                calculateNewCosts();
                calculateSavings();
                
                // Extract numeric values from text content (remove " EUR" or other text)
                const currentTotalText = document.getElementById('current-total').textContent.trim();
                const newTotalText = document.getElementById('new-total').textContent.trim();
                const currentTotal = parseFloat(currentTotalText.replace(/[^\d.,]/g, '').replace(',', '.')) || 0;
                const newTotal = parseFloat(newTotalText.replace(/[^\d.,]/g, '').replace(',', '.')) || 0;
                
                const data = {
                    current_provider: document.getElementById('current-provider').value,
                    current_tariff: document.getElementById('current-tariff').value,
                    current_location: document.getElementById('current-location').value,
                    current_consumption: document.getElementById('current-consumption').value,
                    current_months: document.getElementById('current-months').value,
                    current_working_price: document.getElementById('current-working-price').value,
                    current_basic_price: document.getElementById('current-basic-price').value,
                    current_total: currentTotal,
                    new_provider: document.getElementById('new-provider').value,
                    new_tariff: document.getElementById('new-tariff').value,
                    new_location: document.getElementById('new-location').value,
                    new_consumption: document.getElementById('new-consumption').value,
                    new_months: document.getElementById('new-months').value,
                    new_working_price: document.getElementById('new-working-price').value,
                    new_basic_price: document.getElementById('new-basic-price').value,
                    new_total: newTotal,
                    savings_year1_eur: parseFloat(document.getElementById('savings-year1-eur').textContent) || 0,
                    savings_year1_percent: parseFloat(document.getElementById('savings-year1-percent').textContent) || 0,
                    savings_year2_eur: parseFloat(document.getElementById('savings-year2-eur').textContent) || 0,
                    savings_year2_percent: parseFloat(document.getElementById('savings-year2-percent').textContent) || 0,
                    savings_max_eur: parseFloat(document.getElementById('savings-max-eur').textContent) || 0,
                    savings_max_percent: parseFloat(document.getElementById('savings-max-percent').textContent) || 0
                };

                // Determine URL based on type
                let url;
                if (type === 'user') {
                    url = `/admin/users/${userId}/eka`;
                } else {
                    url = `/admin/referrals/${referralId}/eka`;
                }

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('EKA-Daten erfolgreich gespeichert! Die Daten werden jetzt auf der Angebot-Seite angezeigt.');
                        // Reload the data to show what was saved
                        const modal = document.getElementById('ekaModal');
                        const modalType = modal.dataset.type;
                        const modalId = modalType === 'user' ? modal.dataset.userId : modal.dataset.referralId;
                        loadEkaData(modalType, modalId);
                    } else {
                        alert('Fehler beim Speichern der Daten.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Fehler beim Speichern der Daten.');
                });
            }

            document.getElementById('ekaModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeEkaModal();
                }
            });

            function toggleProfileLock(userId, locked) {
                // Sende AJAX-Request zum Server
                fetch(`/admin/users/${userId}/profile-lock`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        locked: locked
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.message || 'Network response was not ok');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Lade die Seite neu, um die aktualisierten Buttons anzuzeigen
                        location.reload();
                    } else {
                        alert('Fehler beim Aktualisieren des Profil-Status: ' + (data.message || 'Unbekannter Fehler'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Fehler beim Aktualisieren des Profil-Status: ' + error.message);
                });
            }
        </script>
    </body>
</html>
