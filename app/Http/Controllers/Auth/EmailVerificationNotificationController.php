<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        try {
            $request->user()->sendEmailVerificationNotification();
            return back()->with('status', 'verification-link-sent');
        } catch (\Exception $e) {
            // Logge den Fehler
            \Log::error('Fehler beim Versenden der Verifizierungs-E-Mail: ' . $e->getMessage());
            // Zeige dem User eine Fehlermeldung
            return back()->with('error', 'Die E-Mail konnte nicht gesendet werden. Bitte überprüfen Sie Ihre E-Mail-Konfiguration oder versuchen Sie es später erneut.');
        }
    }
}
