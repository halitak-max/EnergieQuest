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
        return view('uploads.index', compact('uploads', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

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

        // Prüfe ob der Slot bereits belegt ist
        $existingAppointment = Appointment::where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();
        
        if ($existingAppointment) {
            return response()->json([
                'success' => false,
                'message' => 'Dieser Zeitslot ist bereits belegt. Bitte wählen Sie einen anderen Slot aus.'
            ], 400);
        }

        $user = Auth::user();
        
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
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
        ]);

        $date = $request->date;

        // Hole alle belegten Slots für dieses Datum
        // Konvertiere TIME zu H:i Format (z.B. '14:45:00' zu '14:45')
        $bookedSlots = Appointment::where('appointment_date', $date)
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->map(function($appointment) {
                // Konvertiere TIME Format (H:i:s) zu H:i Format
                $time = $appointment->appointment_time;
                if (is_string($time)) {
                    // Falls bereits im H:i Format
                    if (strlen($time) === 5) {
                        return $time;
                    }
                    // Falls im H:i:s Format, nimm nur H:i
                    return substr($time, 0, 5);
                }
                // Falls Carbon/DateTime Objekt
                return $time->format('H:i');
            })
            ->toArray();

        // Generiere alle verfügbaren Slots von 09:00 bis 18:00 in 15-Minuten-Schritten
        $allSlots = [];
        for ($hour = 9; $hour < 18; $hour++) {
            for ($minute = 0; $minute < 60; $minute += 15) {
                $timeString = sprintf('%02d:%02d', $hour, $minute);
                $allSlots[] = $timeString;
            }
        }

        // Markiere Slots als belegt oder verfügbar
        $slots = [];
        foreach ($allSlots as $slot) {
            $slots[] = [
                'time' => $slot,
                'available' => !in_array($slot, $bookedSlots, true) // Strict comparison
            ];
        }

        return response()->json([
            'success' => true,
            'slots' => $slots,
            'booked_slots' => $bookedSlots
        ]);
    }
}
