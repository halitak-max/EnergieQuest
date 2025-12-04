<?php

namespace App\Http\Controllers;

use App\Mail\AdminNewUpload;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function index()
    {
        $uploads = Auth::user()->uploads()->latest()->get();
        return view('uploads.index', compact('uploads'));
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

        return redirect()->route('uploads.index')->with('success', 'Datei erfolgreich hochgeladen!');
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

        return redirect()->route('uploads.index')->with('success', 'Datei gelöscht.');
    }
}
