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
}
