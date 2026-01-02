@php
    $missingFields = [];
    if (Auth::check() && Auth::user()) {
        $user = Auth::user();
        if (empty($user->iban) || empty($user->birth_date)) {
            if (empty($user->iban)) {
                $missingFields[] = 'IBAN';
            }
            if (empty($user->birth_date)) {
                $missingFields[] = 'Geburtsdatum';
            }
        }
    }
    $showWarning = !empty($missingFields);
@endphp

<!-- Mobile Bottom Nav -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 shadow-lg">
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="flex items-center justify-around h-16">
            <a href="{{ route('home') }}" class="flex flex-col items-center justify-center flex-1 h-full transition-all duration-200 group {{ request()->routeIs('home') ? 'text-yellow-500' : 'text-gray-500 hover:text-yellow-400' }}">
                <div class="w-10 h-10 flex items-center justify-center rounded-full transition-all duration-200 {{ request()->routeIs('home') ? 'bg-yellow-50' : 'group-hover:bg-gray-50' }}">
                    <i class="ri-home-5-fill text-xl"></i>
                </div>
                <span class="text-xs mt-1 font-medium whitespace-nowrap {{ request()->routeIs('home') ? 'text-yellow-500' : 'text-gray-600' }}">Home</span>
            </a>
            <a href="{{ route('uploads.index') }}" class="flex flex-col items-center justify-center flex-1 h-full transition-all duration-200 group {{ request()->routeIs('uploads.*') ? 'text-yellow-500' : 'text-gray-500 hover:text-yellow-400' }}">
                <div class="w-10 h-10 flex items-center justify-center rounded-full transition-all duration-200 {{ request()->routeIs('uploads.*') ? 'bg-yellow-50' : 'group-hover:bg-gray-50' }}">
                    <i class="ri-flashlight-fill text-xl"></i>
                </div>
                <span class="text-xs mt-1 font-medium whitespace-nowrap {{ request()->routeIs('uploads.*') ? 'text-yellow-500' : 'text-gray-600' }}">Angebot</span>
            </a>
            <a href="{{ route('empfehlungen') }}" class="flex flex-col items-center justify-center flex-1 h-full transition-all duration-200 group {{ request()->routeIs('empfehlungen') ? 'text-yellow-500' : 'text-gray-500 hover:text-yellow-400' }}">
                <div class="w-10 h-10 flex items-center justify-center rounded-full transition-all duration-200 {{ request()->routeIs('empfehlungen') ? 'bg-yellow-50' : 'group-hover:bg-gray-50' }}">
                    <i class="ri-user-add-fill text-xl"></i>
                </div>
                <span class="text-xs mt-1 font-medium whitespace-nowrap {{ request()->routeIs('empfehlungen') ? 'text-yellow-500' : 'text-gray-600' }}">Empfehlung</span>
            </a>
            <a href="{{ route('gutscheine') }}" class="flex flex-col items-center justify-center flex-1 h-full transition-all duration-200 group {{ request()->routeIs('gutscheine') ? 'text-yellow-500' : 'text-gray-500 hover:text-yellow-400' }}">
                <div class="w-10 h-10 flex items-center justify-center rounded-full transition-all duration-200 {{ request()->routeIs('gutscheine') ? 'bg-yellow-50' : 'group-hover:bg-gray-50' }}">
                    <i class="ri-gift-fill text-xl"></i>
                </div>
                <span class="text-xs mt-1 font-medium whitespace-nowrap {{ request()->routeIs('gutscheine') ? 'text-yellow-500' : 'text-gray-600' }}">Gutscheine</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center justify-center flex-1 h-full transition-all duration-200 group {{ request()->routeIs('profile.edit') ? 'text-yellow-500' : 'text-gray-500 hover:text-yellow-400' }}" style="position: relative;" id="profile-nav-link">
                <div class="w-10 h-10 flex items-center justify-center rounded-full transition-all duration-200 {{ request()->routeIs('profile.edit') ? 'bg-yellow-50' : 'group-hover:bg-gray-50' }}">
                    <i class="ri-user-fill text-xl"></i>
                </div>
                <span class="text-xs mt-1 font-medium whitespace-nowrap {{ request()->routeIs('profile.edit') ? 'text-yellow-500' : 'text-gray-600' }}">Profil</span>
                <span id="profile-warning-icon" class="absolute top-0 right-0 text-red-500 text-lg font-bold hidden" style="transform: translate(25%, -25%);">!</span>
            </a>
        </div>
    </div>
</nav>

<script>
    function updateProfileWarningIcon() {
        const offerButtonClicked = localStorage.getItem('offerButtonClicked') === 'true';
        const warningIcon = document.getElementById('profile-warning-icon');
        
        const isOnOfferPage = window.location.pathname.includes('/uploads') || window.location.pathname.includes('/angebot');
        
        if (!isOnOfferPage) {
            if (warningIcon) {
                warningIcon.classList.add('hidden');
            }
            return;
        }
        
        @if($showWarning)
            if (offerButtonClicked && isOnOfferPage && warningIcon) {
                warningIcon.classList.remove('hidden');
            } else if (warningIcon) {
                warningIcon.classList.add('hidden');
            }
        @else
            if (offerButtonClicked) {
                localStorage.removeItem('offerButtonClicked');
            }
            if (warningIcon) {
                warningIcon.classList.add('hidden');
            }
        @endif
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        updateProfileWarningIcon();
        setInterval(function() {
            updateProfileWarningIcon();
        }, 1000);
    });
    
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href) {
            const href = link.href;
            const isOfferLink = href.includes('/uploads') || href.includes('/angebot');
            const isProfileLink = href.includes('/profile') || href.includes('/profil');
            
            if (!isOfferLink && !isProfileLink) {
                const offerButtonClicked = localStorage.getItem('offerButtonClicked') === 'true';
                if (offerButtonClicked) {
                    localStorage.removeItem('offerButtonClicked');
                    updateProfileWarningIcon();
                }
            }
        }
    });
    
    window.addEventListener('storage', function(e) {
        if (e.key === 'offerButtonClicked') {
            updateProfileWarningIcon();
        }
    });
</script>

