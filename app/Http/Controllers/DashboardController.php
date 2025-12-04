<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Accessor from User model
        $currentLevel = $user->level;
        
        // Stats
        $totalReferrals = $user->referrals()->count();
        $approvedReferrals = $user->referrals()->where('status', 2)->count();
        
        // Thresholds matching User model logic
        $thresholds = [
            1 => 1,
            2 => 3,
            3 => 5,
            4 => 7,
            5 => 10,
            6 => 15,
            7 => 20, 
        ];
        
        $nextLevel = $currentLevel + 1;
        $needed = $thresholds[$nextLevel] ?? 0;
        $progress = 0;
        
        if ($currentLevel < 7) {
             if ($needed > 0) {
                // Progress is percentage of approved referrals towards the next level target
                // This is a simple calculation: approved / target * 100
                $progress = min(100, round(($approvedReferrals / $needed) * 100));
             }
        } else {
            $progress = 100;
        }

        return view('dashboard', compact('user', 'currentLevel', 'totalReferrals', 'approvedReferrals', 'progress', 'needed'));
    }
}
