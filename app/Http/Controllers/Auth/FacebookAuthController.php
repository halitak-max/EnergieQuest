<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class FacebookAuthController extends Controller
{
    /**
     * Redirect the user to the Facebook authentication page.
     */
    public function redirectToFacebook(): RedirectResponse
    {
        return Socialite::driver('facebook')
            ->scopes(['email'])
            ->redirectUrl(route('auth.facebook.callback'))
            ->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     */
    public function handleFacebookCallback(Request $request): RedirectResponse
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            
            // Debug: Logge die erhaltenen Daten
            \Log::info('Facebook OAuth User Data', [
                'email' => $facebookUser->getEmail(),
                'name' => $facebookUser->getName(),
                'id' => $facebookUser->getId(),
            ]);
            
            // Prüfe ob E-Mail vorhanden ist
            if (!$facebookUser->getEmail()) {
                \Log::error('Facebook OAuth: Keine E-Mail-Adresse erhalten');
                return redirect()->route('login')->with('error', 'Facebook hat keine E-Mail-Adresse zurückgegeben. Bitte versuchen Sie es erneut oder registrieren Sie sich manuell.');
            }
            
            // Prüfe ob Name vorhanden ist, sonst verwende E-Mail
            $name = $facebookUser->getName() ?: $facebookUser->getEmail();
            
            // Prüfe ob User bereits existiert
            $user = User::where('email', $facebookUser->getEmail())->first();

            if ($user) {
                // User existiert bereits - aktualisiere facebook_id und markiere E-Mail als verifiziert
                $needsUpdate = false;
                
                if (empty($user->facebook_id)) {
                    $user->facebook_id = $facebookUser->getId();
                    $needsUpdate = true;
                }
                
                // Markiere E-Mail als verifiziert (Facebook E-Mails sind bereits verifiziert)
                if (empty($user->email_verified_at)) {
                    $user->email_verified_at = now();
                    $needsUpdate = true;
                }
                
                if ($needsUpdate) {
                    $user->save();
                }
                
                \Log::info('Facebook OAuth: Bestehender User gefunden', ['user_id' => $user->id]);
            } else {
                // Neuer User - erstelle Account
                try {
                    $user = User::create([
                        'name' => $name,
                        'email' => $facebookUser->getEmail(),
                        'email_verified_at' => now(), // Facebook E-Mails sind bereits verifiziert
                        'password' => null, // OAuth-User haben kein Passwort
                        'facebook_id' => $facebookUser->getId(),
                    ]);
                    \Log::info('Facebook OAuth: Neuer User erstellt', ['user_id' => $user->id]);
                } catch (\Exception $e) {
                    \Log::error('Facebook OAuth: Fehler beim Erstellen des Users', [
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
            
            \Log::info('Facebook OAuth: User eingeloggt und Session regeneriert', [
                'user_id' => $user->id,
                'email_verified' => $user->hasVerifiedEmail(),
                'authenticated' => Auth::check()
            ]);

            // Direkt zum Dashboard weiterleiten (Facebook-User sind bereits verifiziert)
            return redirect()->route('home');
        } catch (\Exception $e) {
            \Log::error('Facebook OAuth Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return redirect()->route('login')->with('error', 'Fehler beim Anmelden mit Facebook. Bitte versuchen Sie es erneut.');
        }
    }

}

