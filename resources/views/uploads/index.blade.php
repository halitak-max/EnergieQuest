<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Uploads') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container" style="max-width: 100%;">

                <!-- Welcome -->
                <div class="welcome-section text-center mb-6">
                    <h1 class="text-2xl font-bold">Dateien hochladen</h1>
                    <p>Lade meine Energiedaten und Dokumente hoch</p>
                </div>

                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                     <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Upload Form -->
                <div class="card bg-white p-6 rounded shadow mb-6">
                    <form action="{{ route('uploads.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                        <div class="upload-dropzone border-2 border-dashed border-gray-300 rounded-lg p-10 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-50 transition" onclick="document.getElementById('fileInput').click()">
                            <i class="fa-solid fa-cloud-arrow-up text-4xl text-blue-500 mb-2"></i>
                            <h3 class="font-semibold text-lg">Datei auswählen</h3>
                            <p class="text-gray-500 text-sm mt-1">Klicken zum Auswählen (Max 10MB)</p>
                            <input type="file" name="file" id="fileInput" class="hidden" onchange="document.getElementById('uploadForm').submit()">
                        </div>
                    </form>
                </div>

                <!-- File List -->
                <div class="card bg-white p-6 rounded shadow">
                    <h3 class="font-bold text-lg mb-4">Meine Uploads</h3>
                    
                    @if($uploads->count() > 0)
                        <div class="space-y-3">
                            @foreach($uploads as $upload)
                                <div class="file-list-item flex justify-between items-center p-3 bg-gray-50 rounded hover:bg-gray-100">
                                    <div>
                                        <div class="font-medium">{{ $upload->original_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $upload->created_at->format('d.m.Y H:i') }}</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ Storage::url($upload->file_path) }}" target="_blank" class="text-blue-500 hover:text-blue-700">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                        <form action="{{ route('uploads.destroy', $upload) }}" method="POST" onsubmit="return confirm('Wirklich löschen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                         <p class="text-center text-gray-500 text-sm">Noch keine Dateien hochgeladen.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <!-- Bottom Nav -->
    <nav class="bottom-nav fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 flex justify-around py-2 sm:hidden z-50">
        <a href="{{ route('dashboard') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-house nav-icon text-xl"></i>
            <span class="text-xs mt-1">Home</span>
        </a>
        <a href="{{ route('empfehlungen') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('empfehlungen') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-user-plus nav-icon text-xl"></i>
            <span class="text-xs mt-1">Empfehlungen</span>
        </a>
        <a href="{{ route('gutscheine') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('gutscheine') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-ticket nav-icon text-xl"></i>
            <span class="text-xs mt-1">Gutscheine</span>
        </a>
        <a href="{{ route('uploads.index') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('uploads.*') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-solid fa-cloud-arrow-up nav-icon text-xl"></i>
            <span class="text-xs mt-1">Uploads</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('profile.edit') ? 'text-blue-600' : 'text-gray-500' }}">
            <i class="fa-regular fa-user nav-icon text-xl"></i>
            <span class="text-xs mt-1">Profil</span>
        </a>
    </nav>
</x-app-layout>
