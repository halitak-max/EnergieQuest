<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Upload;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Übersichtsseite - zeigt Statistiken und Links zu den einzelnen Tabellen
        $stats = [
            'users_with_accepted_offer' => User::where('offer_accepted', true)->count(),
            'total_users' => User::count(),
            'total_uploads' => Upload::count(),
            'total_appointments' => Appointment::count(),
            'total_referrals' => Referral::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function acceptedOffers()
    {
        $uploads = Upload::with('user')->latest()->get();
        $appointments = Appointment::with('user')->orderBy('appointment_date')->orderBy('appointment_time')->get();
        $usersWithAcceptedOffer = User::where('offer_accepted', true)->with('referrer')->latest()->get();

        return view('admin.accepted-offers', compact('uploads', 'appointments', 'usersWithAcceptedOffer'));
    }

    public function masterOverview()
    {
        $uploads = Upload::with('user')->latest()->get();
        $referrals = Referral::with(['referrer', 'referredUser'])->latest()->get();
        $users = User::with('referrer')->latest()->get();
        $appointments = Appointment::with('user')->orderBy('appointment_date')->orderBy('appointment_time')->get();

        return view('admin.master-overview', compact('uploads', 'referrals', 'users', 'appointments'));
    }

    public function uploads()
    {
        $uploads = Upload::with('user')->latest()->get();
        return view('admin.uploads', compact('uploads'));
    }

    public function referrals()
    {
        $referrals = Referral::with(['referrer', 'referredUser'])->latest()->get();
        return view('admin.referrals', compact('referrals'));
    }

    public function appointments()
    {
        $appointments = Appointment::with('user')->orderBy('appointment_date')->orderBy('appointment_time')->get();
        return view('admin.appointments', compact('appointments'));
    }

    public function users()
    {
        $users = User::with('referrer')->latest()->get();
        return view('admin.users', compact('users'));
    }

    public function getUserEkaData(User $user)
    {
        return response()->json([
            'current_provider' => $user->current_provider,
            'current_tariff' => $user->current_tariff,
            'current_location' => $user->current_location,
            'current_consumption' => $user->current_consumption,
            'current_months' => $user->current_months ?? 12,
            'current_working_price' => $user->current_working_price,
            'current_basic_price' => $user->current_basic_price,
            'current_total' => $user->current_total,
            'new_provider' => $user->new_provider,
            'new_tariff' => $user->new_tariff,
            'new_location' => $user->new_location,
            'new_consumption' => $user->new_consumption,
            'new_months' => $user->new_months ?? 12,
            'new_working_price' => $user->new_working_price,
            'new_basic_price' => $user->new_basic_price,
            'new_total' => $user->new_total,
            'savings_year1_eur' => $user->savings_year1_eur,
            'savings_year1_percent' => $user->savings_year1_percent,
            'savings_year2_eur' => $user->savings_year2_eur,
            'savings_year2_percent' => $user->savings_year2_percent,
            'savings_max_eur' => $user->savings_max_eur,
            'savings_max_percent' => $user->savings_max_percent,
        ]);
    }

    public function getReferralEkaData(Referral $referral)
    {
        return response()->json([
            'current_provider' => $referral->current_provider,
            'current_tariff' => $referral->current_tariff,
            'current_location' => $referral->current_location,
            'current_consumption' => $referral->current_consumption,
            'current_months' => $referral->current_months ?? 12,
            'current_working_price' => $referral->current_working_price,
            'current_basic_price' => $referral->current_basic_price,
            'current_total' => $referral->current_total,
            'new_provider' => $referral->new_provider,
            'new_tariff' => $referral->new_tariff,
            'new_location' => $referral->new_location,
            'new_consumption' => $referral->new_consumption,
            'new_months' => $referral->new_months ?? 12,
            'new_working_price' => $referral->new_working_price,
            'new_basic_price' => $referral->new_basic_price,
            'new_total' => $referral->new_total,
            'savings_year1_eur' => $referral->savings_year1_eur,
            'savings_year1_percent' => $referral->savings_year1_percent,
            'savings_year2_eur' => $referral->savings_year2_eur,
            'savings_year2_percent' => $referral->savings_year2_percent,
            'savings_max_eur' => $referral->savings_max_eur,
            'savings_max_percent' => $referral->savings_max_percent,
        ]);
    }

    public function updateReferralStatus(Request $request, Referral $referral)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1,2',
        ]);

        $referral->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status erfolgreich aktualisiert',
            'status' => $referral->status,
        ]);
    }

    public function saveEkaData(Request $request, Referral $referral)
    {
        $request->validate([
            'current_provider' => 'nullable|string|max:255',
            'current_tariff' => 'nullable|string|max:255',
            'current_location' => 'nullable|string|max:255',
            'current_consumption' => 'nullable|integer',
            'current_months' => 'nullable|integer',
            'current_working_price' => 'nullable|numeric',
            'current_basic_price' => 'nullable|numeric',
            'new_provider' => 'nullable|string|max:255',
            'new_tariff' => 'nullable|string|max:255',
            'new_location' => 'nullable|string|max:255',
            'new_consumption' => 'nullable|integer',
            'new_months' => 'nullable|integer',
            'new_working_price' => 'nullable|numeric',
            'new_basic_price' => 'nullable|numeric',
            'savings_year1_eur' => 'nullable|numeric',
            'savings_year1_percent' => 'nullable|numeric',
            'savings_year2_eur' => 'nullable|numeric',
            'savings_year2_percent' => 'nullable|numeric',
            'savings_max_eur' => 'nullable|numeric',
            'savings_max_percent' => 'nullable|numeric',
        ]);

        $referral->update($request->only([
            'current_provider', 'current_tariff', 'current_location', 'current_consumption',
            'current_months', 'current_working_price', 'current_basic_price', 'current_total',
            'new_provider', 'new_tariff', 'new_location', 'new_consumption',
            'new_months', 'new_working_price', 'new_basic_price', 'new_total',
            'savings_year1_eur', 'savings_year1_percent', 'savings_year2_eur', 'savings_year2_percent',
            'savings_max_eur', 'savings_max_percent'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'EKA-Daten erfolgreich gespeichert',
        ]);
    }

    public function saveUserEkaData(Request $request, User $user)
    {
        $request->validate([
            'current_provider' => 'nullable|string|max:255',
            'current_tariff' => 'nullable|string|max:255',
            'current_location' => 'nullable|string|max:255',
            'current_consumption' => 'nullable|integer',
            'current_months' => 'nullable|integer',
            'current_working_price' => 'nullable|numeric',
            'current_basic_price' => 'nullable|numeric',
            'new_provider' => 'nullable|string|max:255',
            'new_tariff' => 'nullable|string|max:255',
            'new_location' => 'nullable|string|max:255',
            'new_consumption' => 'nullable|integer',
            'new_months' => 'nullable|integer',
            'new_working_price' => 'nullable|numeric',
            'new_basic_price' => 'nullable|numeric',
            'savings_year1_eur' => 'nullable|numeric',
            'savings_year1_percent' => 'nullable|numeric',
            'savings_year2_eur' => 'nullable|numeric',
            'savings_year2_percent' => 'nullable|numeric',
            'savings_max_eur' => 'nullable|numeric',
            'savings_max_percent' => 'nullable|numeric',
        ]);

        // Convert empty strings to null for all fields
        $data = array_map(function($value) {
            return $value === '' ? null : $value;
        }, $request->only([
            'current_provider', 'current_tariff', 'current_location', 'current_consumption',
            'current_months', 'current_working_price', 'current_basic_price', 'current_total',
            'new_provider', 'new_tariff', 'new_location', 'new_consumption',
            'new_months', 'new_working_price', 'new_basic_price', 'new_total',
            'savings_year1_eur', 'savings_year1_percent', 'savings_year2_eur', 'savings_year2_percent',
            'savings_max_eur', 'savings_max_percent'
        ]));
        
        // Calculate current_total if not provided but we have the necessary data
        if (!isset($data['current_total']) || $data['current_total'] === null) {
            $currentConsumption = $data['current_consumption'] ?? 0;
            $currentWorkingPrice = $data['current_working_price'] ?? 0;
            $currentBasicPrice = $data['current_basic_price'] ?? 0;
            $currentMonths = $data['current_months'] ?? 12;
            
            if ($currentConsumption > 0 && $currentWorkingPrice > 0) {
                $consumptionCost = ($currentConsumption * $currentWorkingPrice) / 100;
                $basicYear = $currentBasicPrice * $currentMonths;
                $data['current_total'] = $consumptionCost + $basicYear;
            }
        }
        
        // Calculate new_total if not provided but we have the necessary data
        if (!isset($data['new_total']) || $data['new_total'] === null) {
            $newConsumption = $data['new_consumption'] ?? 0;
            $newWorkingPrice = $data['new_working_price'] ?? 0;
            $newBasicPrice = $data['new_basic_price'] ?? 0;
            $newMonths = $data['new_months'] ?? 12;
            
            if ($newConsumption > 0 && $newWorkingPrice > 0) {
                $consumptionCost = ($newConsumption * $newWorkingPrice) / 100;
                $basicYear = $newBasicPrice * $newMonths;
                $data['new_total'] = $consumptionCost + $basicYear;
            }
        }
        
        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'EKA-Daten erfolgreich gespeichert',
        ]);
    }

    public function toggleProfileLock(Request $request, User $user)
    {
        $request->validate([
            'locked' => 'required|boolean',
        ]);

        // Prüfe ob es ein Wechsel von true zu false ist (von Ja zu Nein)
        $wasLocked = $user->offer_accepted ?? false;
        $isUnlocking = $wasLocked && !$request->locked;

        // Prüfe ob der User ein Appointment hat
        $hasAppointment = $user->appointments()->exists();

        // Speichere den Status in der Datenbank
        $user->update([
            'offer_accepted' => $request->locked
        ]);

        // Wenn von Ja zu Nein umgeschaltet wurde, setze ein Flag für die Meldung
        if ($isUnlocking) {
            // Wenn kein Appointment vorhanden ist, zeige die "Fast geschafft" Meldung
            if (!$hasAppointment) {
                session()->put('show_offer_almost_done_message_' . $user->id, true);
            } else {
                // Wenn Appointment vorhanden ist, zeige die normale "optimiert" Meldung
                session()->put('show_offer_unlocked_message_' . $user->id, true);
            }
        }

        return response()->json([
            'success' => true,
            'message' => $request->locked ? 'Profil gesperrt' : 'Profil freigeschaltet',
            'locked' => $request->locked,
            'was_unlocked' => $isUnlocking,
        ]);
    }

    public function destroyAppointment(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Termin erfolgreich gelöscht',
        ]);
    }
}
