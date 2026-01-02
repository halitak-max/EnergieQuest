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

<!-- Bottom Nav (Mobile) -->
<nav class="bottom-nav fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 flex justify-around py-2 sm:hidden z-50">
    <a href="{{ route('home') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('home') ? 'text-blue-600' : 'text-gray-500' }}">
        <i class="fa-solid fa-house nav-icon text-xl"></i>
        <span class="text-xs mt-1">Home</span>
    </a>
    <a href="{{ route('uploads.index') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('uploads.*') ? 'text-blue-600' : 'text-gray-500' }}">
        <i class="fa-solid fa-bolt nav-icon text-xl"></i>
        <span class="text-xs mt-1">Angebot</span>
    </a>
    <a href="{{ route('empfehlungen') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('empfehlungen') ? 'text-blue-600' : 'text-gray-500' }}">
        <i class="fa-solid fa-user-plus nav-icon text-xl"></i>
        <span class="text-xs mt-1">Empfehlungen</span>
    </a>
    <a href="{{ route('gutscheine') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('gutscheine') ? 'text-blue-600' : 'text-gray-500' }}">
        <i class="fa-solid fa-ticket nav-icon text-xl"></i>
        <span class="text-xs mt-1">Gutscheine</span>
    </a>
    <a href="{{ route('profile.edit') }}" class="nav-item flex flex-col items-center {{ request()->routeIs('profile.edit') ? 'text-blue-600' : 'text-gray-500' }}" style="position: relative;" id="profile-nav-link">
        <i class="fa-regular fa-user nav-icon text-xl"></i>
        <span class="text-xs mt-1">Profil</span>
        <span id="profile-warning-icon" class="absolute top-0 right-0 text-red-500 text-lg font-bold hidden" style="transform: translate(25%, -25%);">!</span>
    </a>
</nav>

<script>
    function updateProfileWarningIcon() {
        const offerButtonClicked = localStorage.getItem('offerButtonClicked') === 'true';
        const warningIcon = document.getElementById('profile-warning-icon');
        
        // Prüfe ob wir auf der Angebot-Seite sind (wo die Meldung angezeigt wird)
        const isOnOfferPage = window.location.pathname.includes('/uploads') || window.location.pathname.includes('/angebot');
        
        // Wenn der Benutzer nicht auf der Angebot-Seite ist, verstecke das Ausrufezeichen
        if (!isOnOfferPage) {
            if (warningIcon) {
                warningIcon.classList.add('hidden');
            }
            return;
        }
        
        @if($showWarning)
            // Nur auf der Angebot-Seite anzeigen, wenn der Button geklickt wurde (wo die Meldung erscheint)
            if (offerButtonClicked && isOnOfferPage && warningIcon) {
                warningIcon.classList.remove('hidden');
            } else if (warningIcon) {
                warningIcon.classList.add('hidden');
            }
        @else
            // Wenn Felder ausgefüllt sind, entferne den Flag und verstecke das Ausrufezeichen
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
        
        // Prüfe regelmäßig, ob sich der Status geändert hat (z.B. nach dem Speichern des Profils)
        setInterval(function() {
            updateProfileWarningIcon();
        }, 1000);
    });
    
    // Event-Listener für Navigation (wenn der Benutzer zu einer anderen Seite navigiert)
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href) {
            const href = link.href;
            const isOfferLink = href.includes('/uploads') || href.includes('/angebot');
            const isProfileLink = href.includes('/profile') || href.includes('/profil');
            
            // Wenn der Benutzer zu einer anderen Seite navigiert (nicht Angebot oder Profil), entferne den Flag
            if (!isOfferLink && !isProfileLink) {
                const offerButtonClicked = localStorage.getItem('offerButtonClicked') === 'true';
                if (offerButtonClicked) {
                    localStorage.removeItem('offerButtonClicked');
                    updateProfileWarningIcon();
                }
            }
        }
    });
    
    // Event-Listener für Storage-Änderungen (wenn LocalStorage in einem anderen Tab geändert wird)
    window.addEventListener('storage', function(e) {
        if (e.key === 'offerButtonClicked') {
            updateProfileWarningIcon();
        }
    });
</script>
