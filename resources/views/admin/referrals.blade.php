<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'EnergieQuest') }} Admin - Referrals</title>
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
                            <h3 class="font-bold text-lg mb-4">Alle Referrals</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Werber</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Geworbener User</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Datum</th>
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
                                                        onchange="saveReferralStatus({{ $referral->id }})"
                                                    >
                                                        <option value="0" {{ $referral->status == 0 ? 'selected' : '' }}>0</option>
                                                        <option value="1" {{ $referral->status == 1 ? 'selected' : '' }}>1</option>
                                                        <option value="2" {{ $referral->status == 2 ? 'selected' : '' }}>2</option>
                                                    </select>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $referral->created_at->format('d.m.Y H:i') }}
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
                </div>
            </main>
        </div>

        <script>
            function saveReferralStatus(referralId) {
                const select = document.getElementById(`status-select-${referralId}`);
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
        </script>
    </body>
</html>

