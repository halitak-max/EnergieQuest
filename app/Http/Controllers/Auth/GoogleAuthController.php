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
            
            // Prüfe ob User bereits existiert
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // User existiert bereits - aktualisiere google_id falls noch nicht gesetzt
                if (empty($user->google_id)) {
                    $user->google_id = $googleUser->getId();
                    $user->save();
                }
                Auth::login($user, true);
            } else {
                // Neuer User - erstelle Account
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'email_verified_at' => now(), // Google E-Mails sind bereits verifiziert
                    'password' => null, // OAuth-User haben kein Passwort
                    'google_id' => $googleUser->getId(),
                ]);

                // Der referral_code wird automatisch im boot() des Models generiert
                Auth::login($user, true);
            }

            // Session regenerieren (wichtig für Sicherheit)
            $request->session()->regenerate();

            // Direkt zur Home-Seite weiterleiten
            return redirect()->route('home');
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Fehler beim Anmelden mit Google. Bitte versuchen Sie es erneut.');
        }
    }

}

