<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        
        // Combine first_name and last_name into name
        $name = trim($validated['first_name'] . ' ' . $validated['last_name']);
        $validated['name'] = $name;
        unset($validated['first_name'], $validated['last_name']);
        
        // Combine birth date components into birth_date
        if (isset($validated['birth_day']) && isset($validated['birth_month']) && isset($validated['birth_year'])) {
            $validated['birth_date'] = sprintf('%04d-%02d-%02d', 
                $validated['birth_year'], 
                $validated['birth_month'], 
                $validated['birth_day']
            );
            unset($validated['birth_day'], $validated['birth_month'], $validated['birth_year']);
        }
        
        $request->user()->fill($validated);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Quick update for IBAN and birth date only.
     */
    public function quickUpdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'iban' => ['required', 'string', 'max:34'],
                'birth_day' => ['required', 'integer', 'min:1', 'max:31'],
                'birth_month' => ['required', 'integer', 'min:1', 'max:12'],
                'birth_year' => ['required', 'integer', 'min:' . (date('Y') - 100), 'max:' . (date('Y') - 13)],
            ]);

            // Validate date
            if (!checkdate($validated['birth_month'], $validated['birth_day'], $validated['birth_year'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ungültiges Datum',
                    'errors' => [
                        'birth_date' => ['Bitte wählen Sie ein gültiges Geburtsdatum aus.']
                    ]
                ], 422);
            }

            // Combine birth date components into birth_date
            $birthDate = sprintf('%04d-%02d-%02d', 
                $validated['birth_year'], 
                $validated['birth_month'], 
                $validated['birth_day']
            );

            $request->user()->update([
                'iban' => $validated['iban'],
                'birth_date' => $birthDate,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profil erfolgreich aktualisiert',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validierungsfehler',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
