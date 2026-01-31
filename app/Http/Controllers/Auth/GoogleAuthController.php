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
                // User existiert bereits - aktualisiere google_id und markiere E-Mail als verifiziert
                $needsUpdate = false;
                
                if (empty($user->google_id)) {
                    $user->google_id = $googleUser->getId();
                    $needsUpdate = true;
                }
                
                // Markiere E-Mail als verifiziert (Google E-Mails sind bereits verifiziert)
                if (empty($user->email_verified_at)) {
                    $user->email_verified_at = now();
                    $needsUpdate = true;
                }
                
                if ($needsUpdate) {
                    $user->save();
                }
                
                \Log::info('Google OAuth: Bestehender User gefunden', ['user_id' => $user->id]);
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
            }

            // User einloggen
            Auth::login($user, true);
            
            // Session regenerieren (wichtig für Sicherheit)
            $request->session()->regenerate();
            
            \Log::info('Google OAuth: User eingeloggt und Session regeneriert', [
                'user_id' => $user->id,
                'email_verified' => $user->hasVerifiedEmail(),
                'authenticated' => Auth::check()
            ]);

            // Direkt zum Dashboard weiterleiten (Google-User sind bereits verifiziert)
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

