<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EnergieQuest') }} Admin - Termine</title>
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
                            <h3 class="font-bold text-lg mb-4">Termine</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">E-Mail</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Telefon</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Datum</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Uhrzeit</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Erstellt am</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Aktionen</th>
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
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <button 
                                                        onclick="deleteAppointment({{ $appointment->id }})" 
                                                        class="px-3 py-1 bg-red-500 text-white rounded-lg text-xs font-medium hover:bg-red-600 transition-colors cursor-pointer"
                                                        title="Termin löschen"
                                                    >
                                                        <i class="fa-solid fa-trash"></i> Löschen
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">Keine Termine vorhanden</td>
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

        <script>
            function deleteAppointment(appointmentId) {
                if (!confirm('Möchten Sie diesen Termin wirklich löschen? Diese Aktion kann nicht rückgängig gemacht werden.')) {
                    return;
                }

                fetch(`/admin/appointments/${appointmentId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Fehler beim Löschen des Termins: ' + (data.message || 'Unbekannter Fehler'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Fehler beim Löschen des Termins');
                });
            }
        </script>
    </body>
</html>

