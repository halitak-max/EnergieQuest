<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $referrals = $user->referrals()->with('referredUser')->latest()->get();
        
        $stats = [
            'success' => $user->referrals()->where('status', 2)->count(),
            'pending' => $user->referrals()->where('status', 0)->count(),
        ];

        return view('empfehlungen', compact('referrals', 'stats'));
    }

    public function vouchers()
    {
        $user = Auth::user();
        $currentLevel = $user->level;
        
        // Only status 2 counts for level
        $approvedCount = $user->referrals()->where('status', 2)->count();
        
        // Level config matching Dashboard logic
        $levels = [
            ['level' => 0, 'required' => 0, 'reward' => 'Kein Gutschein', 'value' => 0, 'label' => 'Startlevel'],
            ['level' => 1, 'required' => 1, 'reward' => '15€', 'value' => 15, 'label' => '1 genehmigte Empfehlung'],
            ['level' => 2, 'required' => 3, 'reward' => '25€', 'value' => 25, 'label' => 'Weitere 2 Empfehlungen'],
            ['level' => 3, 'required' => 5, 'reward' => '35€', 'value' => 35, 'label' => 'Weitere 3 Empfehlungen'],
            ['level' => 4, 'required' => 7, 'reward' => '45€', 'value' => 45, 'label' => 'Weitere 4 Empfehlungen'],
            ['level' => 5, 'required' => 10, 'reward' => '55€', 'value' => 55, 'label' => 'Weitere 5 Empfehlungen'],
            ['level' => 6, 'required' => 15, 'reward' => '65€', 'value' => 65, 'label' => 'Weitere 6 Empfehlungen'],
            ['level' => 7, 'required' => 20, 'reward' => '75€', 'value' => 75, 'label' => 'Weitere 7 Empfehlungen'],
        ];

        // Calculate total earned
        $earnedTotal = 0;
        for ($i = 1; $i <= $currentLevel; $i++) {
            $earnedTotal += $levels[$i]['value'];
        }

        // Next level logic
        $nextLevel = $currentLevel < 7 ? $levels[$currentLevel + 1] : null;
        $currentThreshold = $levels[$currentLevel]['required'] ?? 0;
        $nextThreshold = $nextLevel ? $nextLevel['required'] : 0;
        $needed = $nextThreshold;
        
        // Extract additional referrals needed from label (e.g., "Weitere 3 Empfehlungen" -> 3)
        $additionalForNextLevel = 0;
        if ($nextLevel && isset($nextLevel['label'])) {
            if (preg_match('/(\d+)/', $nextLevel['label'], $matches)) {
                $additionalForNextLevel = (int)$matches[1];
            }
        }
        
        // Progress Logic: relative to current level
        $progress = 0;
        if ($nextLevel) {
            if ($nextThreshold > $currentThreshold) {
                // Progress is relative to current level: (approved - current) / (next - current) * 100
                $progressInRange = $approvedCount - $currentThreshold;
                $rangeSize = $nextThreshold - $currentThreshold;
                $progress = min(100, max(0, round(($progressInRange / $rangeSize) * 100)));
            }
        } else {
            $progress = 100;
        }

        return view('gutscheine', compact('currentLevel', 'levels', 'earnedTotal', 'approvedCount', 'nextLevel', 'progress', 'needed', 'currentThreshold', 'nextThreshold', 'additionalForNextLevel'));
    }
}
