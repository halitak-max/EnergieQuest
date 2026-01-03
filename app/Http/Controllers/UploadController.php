<?php

namespace App\Http\Controllers;

use App\Mail\AdminNewUpload;
use App\Models\Appointment;
use App\Models\Upload;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index()
    {
        $uploads = Auth::user()->uploads()->latest()->get();
        // Get current user with EKA data
        $user = Auth::user();
        
        // Get next upcoming appointment (only future appointments)
        $nextAppointment = $user->appointments()
            ->where('appointment_date', '>=', now()->format('Y-m-d'))
            ->where(function($query) {
                $query->where('appointment_date', '>', now()->format('Y-m-d'))
                    ->orWhere(function($q) {
                        $q->where('appointment_date', '=', now()->format('Y-m-d'))
                          ->where('appointment_time', '>', now()->format('H:i'));
                    });
            })
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get()
            ->first(function ($appointment) {
                return $appointment->status !== 'cancelled';
            });
        
        return view('uploads.index', compact('uploads', 'user', 'nextAppointment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $user = Auth::user();
        
        // Prüfe ob User bereits 3 Uploads hat
        $uploadCount = $user->uploads()->count();
        if ($uploadCount >= 3) {
            return redirect()->route('uploads.index')
                ->with('error', 'Sie haben bereits das Maximum von 3 Uploads erreicht. Bitte löschen Sie zuerst eine Datei, um eine neue hochzuladen.');
        }

        // Standard local storage (public disk)
        $path = $request->file('file')->store('uploads', 'public');
        
        $upload = Upload::create([
            'user_id' => Auth::id(),
            'file_path' => $path,
            'original_name' => $request->file('file')->getClientOriginalName(),
        ]);

        // Send email to admin
        try {
             Mail::to('info@energiequest.de')->send(new AdminNewUpload($upload));
        } catch (\Exception $e) {
            \Log::error('Email send failed: ' . $e->getMessage());
        }

        return redirect()->route('uploads.index')->with('upload_success', true);
    }

    public function destroy(Upload $upload)
    {
        if ($upload->user_id !== Auth::id()) {
            abort(403);
        }

        if (Storage::disk('public')->exists($upload->file_path)) {
            Storage::disk('public')->delete($upload->file_path);
        }

        $upload->delete();

        return redirect()->route('uploads.index')->with('success', 'Datei erfolgreich gelöscht.');
    }

    public function acceptOffer(Request $request)
    {
        $user = Auth::user();
        
        // Prüfe ob IBAN und Geburtsdatum ausgefüllt sind
        if (empty($user->iban) || empty($user->birth_date)) {
            return response()->json([
                'success' => false,
                'message' => 'Bitte fülle die Felder IBAN & Geburtsdatum in deinem Profil aus.'
            ], 400);
        }
        
        // Setze den Status in der Datenbank
        $user->update([
            'offer_accepted' => true
        ]);
        
        // Setze Session-Variable für die Informationsmeldung
        session()->put('show_offer_accepted_message_' . $user->id, true);
        
        return response()->json([
            'success' => true,
            'message' => 'Angebot erfolgreich angenommen'
        ]);
    }

    public function getOfferStatus()
    {
        $user = Auth::user();
        return response()->json([
            'offer_accepted' => $user->offer_accepted ?? false
        ]);
    }

    public function storeAppointment(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|string',
        ]);

        // Prüfe ob es ein Wochentag ist (nicht Samstag/Sonntag)
        $selectedDate = new \DateTime($request->appointment_date);
        $dayOfWeek = (int) $selectedDate->format('w'); // 0 = Sonntag, 6 = Samstag
        
        if ($dayOfWeek === 0 || $dayOfWeek === 6) {
            return response()->json([
                'success' => false,
                'message' => 'Bitte wählen Sie nur einen Wochentag (Montag bis Freitag) aus.'
            ], 400);
        }

        $user = Auth::user();
        
        // Prüfe ob User bereits einen zukünftigen Termin hat (nur aktive Termine, keine stornierten)
        // Hole alle zukünftigen Termine und filtere dann in PHP, um sicherzustellen, dass stornierte ausgeschlossen werden
        $allFutureAppointments = $user->appointments()
            ->where(function($query) {
                $query->where('appointment_date', '>', now()->format('Y-m-d'))
                    ->orWhere(function($q) {
                        $q->where('appointment_date', '=', now()->format('Y-m-d'))
                          ->where('appointment_time', '>', now()->format('H:i'));
                    });
            })
            ->get();
        
        // Filtere stornierte Termine raus
        $existingAppointment = $allFutureAppointments->first(function($appointment) {
            return $appointment->status !== 'cancelled';
        });
        
        // Debug: Log den gefundenen Termin (kann später entfernt werden)
        if ($existingAppointment) {
            \Log::info('Existing appointment found', [
                'id' => $existingAppointment->id,
                'status' => $existingAppointment->status,
                'date' => $existingAppointment->appointment_date,
                'time' => $existingAppointment->appointment_time
            ]);
        }
        
        if ($existingAppointment) {
            return response()->json([
                'success' => false,
                'message' => 'Sie haben bereits einen Termin gebucht. Bitte stornieren Sie zuerst Ihren bestehenden Termin.'
            ], 400);
        }
        
        $appointment = Appointment::create([
            'user_id' => $user->id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Termin erfolgreich gebucht',
            'appointment' => $appointment
        ]);
    }

    public function getAvailableSlots(Request $request)
    {
        $date = $request->input('date');
        if (!$date) {
            return response()->json(['success' => false, 'message' => 'Datum fehlt'], 400);
        }

        // Prüfe Wochentag
        try {
            $selectedDate = new \DateTime($date);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ungültiges Datum'], 400);
        }

        $dayOfWeek = (int) $selectedDate->format('w'); // 0 = Sonntag, 6 = Samstag
        
        if ($dayOfWeek === 0 || $dayOfWeek === 6) {
             return response()->json([
                'success' => true,
                'slots' => [], // Leeres Array signalisiert keine Slots
                'message' => 'Keine Termine am Wochenende'
            ]);
        }

        $start = new \DateTime($date . ' 09:00:00');
        $end = new \DateTime($date . ' 18:00:00');
        $interval = new \DateInterval('PT15M');
        $slots = [];

        // Bereits gebuchte Termine abrufen
        // Wir nehmen an, dass 'appointment_time' im Format 'H:i' gespeichert ist (z.B. "09:15")
        $bookedAppointments = Appointment::where('appointment_date', $date)
            ->where('status', '!=', 'cancelled') // Nur aktive Termine berücksichtigen
            ->pluck('appointment_time')
            ->toArray();

        // Wenn das Datum heute ist, filtere vergangene Zeiten raus
        $now = new \DateTime();
        $isToday = $selectedDate->format('Y-m-d') === $now->format('Y-m-d');

        for ($time = clone $start; $time < $end; $time->add($interval)) {
            $timeString = $time->format('H:i');
            
            $isAvailable = !in_array($timeString, $bookedAppointments);

            // Falls heute, prüfe ob Zeit schon vorbei ist (plus Puffer von z.B. 1 Stunde)
            if ($isToday) {
                $slotTime = new \DateTime($date . ' ' . $timeString);
                // Mindestens 1 Stunde in der Zukunft
                if ($slotTime <= (clone $now)->modify('+1 hour')) {
                    $isAvailable = false;
                }
            }

            $slots[] = [
                'time' => $timeString,
                'available' => $isAvailable
            ];
        }

        return response()->json([
            'success' => true,
            'slots' => $slots
        ]);
    }

    public function cancelAppointment(Request $request, Appointment $appointment)
    {
        $user = Auth::user();
        
        // Prüfe ob der Termin dem User gehört
        if ($appointment->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Sie haben keine Berechtigung, diesen Termin zu stornieren.'
            ], 403);
        }
        
        // Prüfe ob der Termin in der Zukunft liegt
        $appointmentDateTime = new \DateTime($appointment->appointment_date->format('Y-m-d') . ' ' . $appointment->appointment_time);
        if ($appointmentDateTime < new \DateTime()) {
            return response()->json([
                'success' => false,
                'message' => 'Vergangene Termine können nicht storniert werden.'
            ], 400);
        }
        
        // Storniere den Termin - setze Status auf 'cancelled'
        $appointment->status = 'cancelled';
        $appointment->save();
        
        // Debug: Log die Stornierung
        \Log::info('Appointment cancelled', [
            'id' => $appointment->id,
            'status' => $appointment->status,
            'date' => $appointment->appointment_date,
            'time' => $appointment->appointment_time
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Termin erfolgreich storniert'
        ]);
    }
}
