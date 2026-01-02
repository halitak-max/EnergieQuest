<div id="cookie-banner" class="fixed bottom-0 left-0 right-0 bg-white border-t-2 border-blue-500 shadow-2xl z-50 transform transition-transform duration-300 hidden" style="transform: translateY(100%);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900 mb-2">🍪 Cookie-Einstellungen</h3>
                <p class="text-sm text-gray-700 mb-2">
                    Wir verwenden Cookies, um die Funktionalität unserer Website zu gewährleisten. 
                    <a href="{{ route('datenschutz') }}" class="text-blue-600 hover:text-blue-800 underline">Mehr erfahren</a>
                </p>
                <p class="text-xs text-gray-600">
                    Notwendige Cookies werden automatisch gesetzt. Sie können Ihre Einstellungen jederzeit ändern.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <button onclick="acceptAllCookies()" class="px-6 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-lg font-medium hover:shadow-lg transition-all cursor-pointer whitespace-nowrap">
                    Alle akzeptieren
                </button>
                <button onclick="acceptNecessaryCookies()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-all cursor-pointer whitespace-nowrap">
                    Nur notwendige
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Prüfe ob Cookie-Einstellungen bereits gespeichert wurden
        const cookieConsent = localStorage.getItem('cookie_consent');
        
        if (!cookieConsent) {
            // Zeige Banner nach kurzer Verzögerung
            setTimeout(function() {
                const banner = document.getElementById('cookie-banner');
                if (banner) {
                    banner.classList.remove('hidden');
                    setTimeout(function() {
                        banner.style.transform = 'translateY(0)';
                    }, 100);
                }
            }, 1000);
        }
    });

    function acceptAllCookies() {
        localStorage.setItem('cookie_consent', 'all');
        localStorage.setItem('cookie_consent_date', new Date().toISOString());
        hideCookieBanner();
    }

    function acceptNecessaryCookies() {
        localStorage.setItem('cookie_consent', 'necessary');
        localStorage.setItem('cookie_consent_date', new Date().toISOString());
        hideCookieBanner();
    }

    function hideCookieBanner() {
        const banner = document.getElementById('cookie-banner');
        if (banner) {
            banner.style.transform = 'translateY(100%)';
            setTimeout(function() {
                banner.classList.add('hidden');
            }, 300);
        }
    }
</script>

