<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} Admin</title>
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/icon.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
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
                                <a href="{{ route('admin.dashboard') }}">
                                    <img src="{{ asset('assets/icon.png') }}" class="block h-9 w-auto" alt="Logo" />
                                </a>
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
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">Keine Uploads vorhanden</td>
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
                </div>
            </main>
        </div>
    </body>
</html>
