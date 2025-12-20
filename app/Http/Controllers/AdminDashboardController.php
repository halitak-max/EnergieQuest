<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use App\Models\Referral;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $uploads = Upload::with('user')->latest()->get();
        $referrals = Referral::with(['referrer', 'referredUser'])->latest()->get();

        return view('admin.dashboard', compact('uploads', 'referrals'));
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
}
