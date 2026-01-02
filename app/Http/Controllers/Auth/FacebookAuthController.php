<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
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
            ->redirectUrl(route('auth.facebook.callback'))
            ->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     */
    public function handleFacebookCallback(): RedirectResponse
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();
            
            // Prüfe ob User bereits existiert
            $user = User::where('email', $facebookUser->getEmail())->first();

            if ($user) {
                // User existiert bereits - aktualisiere facebook_id falls noch nicht gesetzt
                if (empty($user->facebook_id)) {
                    $user->facebook_id = $facebookUser->getId();
                    $user->save();
                }
                Auth::login($user, true);
            } else {
                // Neuer User - erstelle Account
                $user = User::create([
                    'name' => $facebookUser->getName(),
                    'email' => $facebookUser->getEmail(),
                    'email_verified_at' => now(), // Facebook E-Mails sind bereits verifiziert
                    'password' => null, // OAuth-User haben kein Passwort
                    'facebook_id' => $facebookUser->getId(),
                ]);

                // Der referral_code wird automatisch im boot() des Models generiert
                Auth::login($user, true);
            }

            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            \Log::error('Facebook OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Fehler beim Anmelden mit Facebook. Bitte versuchen Sie es erneut.');
        }
    }

}

