@php
use Illuminate\Support\Facades\Storage;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EnergieQuest') }} Admin - Angenommene Angebote</title>
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
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen">
            @include('admin.partials.navigation')

            <!-- Page Content -->
            <main class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                    <!-- Users with Accepted Offer Table -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="font-bold text-lg mb-4">Angenommene Angebote</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-Mail</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefon</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IBAN</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Geburtsdatum</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Angebot angenommen am</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploads</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Termine</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-Mail Verifiziert</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Registriert</th>
                                            <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktionen</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($usersWithAcceptedOffer as $user)
                                            @php
                                                $userUploads = $uploads->where('user_id', $user->id);
                                                $userAppointments = $appointments->where('user_id', $user->id);
                                            @endphp
                                            <tr>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->id }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ $user->name }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->phone ?? '-' }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->iban ?? '-' }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d.m.Y') : '-' }}</td>
                                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    @if($user->updated_at)
                                                        {{ \Carbon\Carbon::parse($user->updated_at)->format('d.m.Y H:i') }}
                                                    @else
                                                        -
                                                    @endif
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
                                                        style="background: linear-gradient(135deg, #FCD34D 0%, #F59E0B 100%);"
                                                        onclick="openUserEkaModal({{ $user->id }})"
                                                    >
                                                        EKA
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12" class="px-4 py-4 text-center text-sm text-gray-500">Keine Benutzer mit angenommenem Angebot vorhanden</td>
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
    </body>
</html>

