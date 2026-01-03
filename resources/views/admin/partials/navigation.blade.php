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
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                        Übersicht
                    </a>
                    <a href="{{ route('admin.accepted-offers') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.accepted-offers') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                        Angenommene Angebote
                    </a>
                    <a href="{{ route('admin.master-overview') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.master-overview') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                        Master-Übersicht
                    </a>
                    <a href="{{ route('admin.uploads') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.uploads') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                        Uploads
                    </a>
                    <a href="{{ route('admin.referrals') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.referrals') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                        Referrals
                    </a>
                    <a href="{{ route('admin.appointments') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.appointments') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                        Termine
                    </a>
                    <a href="{{ route('admin.users') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.users') ? 'border-indigo-400 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium leading-5 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out">
                        Alle User
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

