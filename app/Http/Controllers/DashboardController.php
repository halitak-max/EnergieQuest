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
            0 => 0,
            1 => 1,
            2 => 3,
            3 => 5,
            4 => 7,
            5 => 10,
            6 => 15,
            7 => 20, 
        ];
        
        // Additional referrals needed for each level (from labels)
        $additionalNeeded = [
            1 => 1,  // Level 1: 1 genehmigte Empfehlung
            2 => 2,  // Level 2: Weitere 2 Empfehlungen
            3 => 3,  // Level 3: Weitere 3 Empfehlungen
            4 => 4,  // Level 4: Weitere 4 Empfehlungen
            5 => 5,  // Level 5: Weitere 5 Empfehlungen
            6 => 6,  // Level 6: Weitere 6 Empfehlungen
            7 => 7,  // Level 7: Weitere 7 Empfehlungen
        ];
        
        $nextLevel = $currentLevel + 1;
        $currentThreshold = $thresholds[$currentLevel] ?? 0;
        $nextThreshold = $thresholds[$nextLevel] ?? 0;
        $needed = $nextThreshold;
        $additionalForNextLevel = $additionalNeeded[$nextLevel] ?? 0;
        $progress = 0;
        
        if ($currentLevel < 7) {
            if ($nextThreshold > $currentThreshold) {
                // Progress is relative to current level: (approved - current) / (next - current) * 100
                $progressInRange = $approvedReferrals - $currentThreshold;
                $rangeSize = $nextThreshold - $currentThreshold;
                $progress = min(100, max(0, round(($progressInRange / $rangeSize) * 100)));
            }
        } else {
            $progress = 100;
        }

        return view('dashboard', compact('user', 'currentLevel', 'totalReferrals', 'approvedReferrals', 'progress', 'needed', 'thresholds', 'currentThreshold', 'nextThreshold', 'additionalForNextLevel'));
    }
}
