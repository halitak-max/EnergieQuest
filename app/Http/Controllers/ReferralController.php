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
            ['level' => 2, 'required' => 3, 'reward' => '25€', 'value' => 25, 'label' => 'Insgesamt 3 Empfehlungen'],
            ['level' => 3, 'required' => 5, 'reward' => '35€', 'value' => 35, 'label' => 'Insgesamt 5 Empfehlungen'],
            ['level' => 4, 'required' => 7, 'reward' => '45€', 'value' => 45, 'label' => 'Insgesamt 7 Empfehlungen'],
            ['level' => 5, 'required' => 10, 'reward' => '55€', 'value' => 55, 'label' => 'Insgesamt 10 Empfehlungen'],
            ['level' => 6, 'required' => 15, 'reward' => '65€', 'value' => 65, 'label' => 'Insgesamt 15 Empfehlungen'],
            ['level' => 7, 'required' => 20, 'reward' => '75€', 'value' => 75, 'label' => 'Insgesamt 20 Empfehlungen'],
        ];

        // Calculate total earned
        $earnedTotal = 0;
        for ($i = 1; $i <= $currentLevel; $i++) {
            $earnedTotal += $levels[$i]['value'];
        }

        // Next level logic
        $nextLevel = $currentLevel < 7 ? $levels[$currentLevel + 1] : null;
        $needed = $nextLevel ? $nextLevel['required'] : 0;
        
        // Progress Logic from DashboardController (Absolute)
        $progress = 0;
        if ($nextLevel) {
             if ($needed > 0) {
                $progress = min(100, round(($approvedCount / $needed) * 100));
             }
        } else {
            $progress = 100;
        }

        return view('gutscheine', compact('currentLevel', 'levels', 'earnedTotal', 'approvedCount', 'nextLevel', 'progress', 'needed'));
    }
}
