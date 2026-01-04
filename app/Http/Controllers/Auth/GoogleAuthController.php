<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirectUrl(route('auth.google.callback'))
            ->redirect();
    }

    /**
     * Obtain the user information from Google.
     */
    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Debug: Logge die erhaltenen Daten
            \Log::info('Google OAuth User Data', [
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'id' => $googleUser->getId(),
            ]);
            
            // Prüfe ob E-Mail vorhanden ist
            if (!$googleUser->getEmail()) {
                \Log::error('Google OAuth: Keine E-Mail-Adresse erhalten');
                return redirect()->route('login')->with('error', 'Google hat keine E-Mail-Adresse zurückgegeben. Bitte versuchen Sie es erneut oder registrieren Sie sich manuell.');
            }
            
            // Prüfe ob Name vorhanden ist, sonst verwende E-Mail
            $name = $googleUser->getName() ?: $googleUser->getEmail();
            
            // Prüfe ob User bereits existiert
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // User existiert bereits - aktualisiere google_id falls noch nicht gesetzt
                if (empty($user->google_id)) {
                    $user->google_id = $googleUser->getId();
                    $user->save();
                }
                Auth::login($user, true);
                \Log::info('Google OAuth: Bestehender User eingeloggt', ['user_id' => $user->id]);
            } else {
                // Neuer User - erstelle Account
                try {
                    $user = User::create([
                        'name' => $name,
                        'email' => $googleUser->getEmail(),
                        'email_verified_at' => now(), // Google E-Mails sind bereits verifiziert
                        'password' => null, // OAuth-User haben kein Passwort
                        'google_id' => $googleUser->getId(),
                    ]);
                    \Log::info('Google OAuth: Neuer User erstellt', ['user_id' => $user->id]);
                } catch (\Exception $e) {
                    \Log::error('Google OAuth: Fehler beim Erstellen des Users', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    return redirect()->route('login')->with('error', 'Fehler beim Erstellen des Benutzerkontos: ' . $e->getMessage());
                }

                // Der referral_code wird automatisch im boot() des Models generiert
                Auth::login($user, true);
            }

            // Session regenerieren (wichtig für Sicherheit)
            $request->session()->regenerate();

            // Direkt zur Home-Seite weiterleiten
            return redirect()->route('home');
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('login')->with('error', 'Fehler beim Anmelden mit Google. Bitte versuchen Sie es erneut.');
        }
    }

}

