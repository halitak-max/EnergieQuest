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
            'success' => $user->referrals()->whereIn('status', [1, 2])->count(),
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
        
        // Level config matching JS logic
        $levels = [
            ['level' => 0, 'required' => 0, 'reward' => 'Kein Gutschein', 'value' => 0, 'label' => 'Startlevel'],
            ['level' => 1, 'required' => 1, 'reward' => '15€', 'value' => 15, 'label' => '1 genehmigte Empfehlung'],
            ['level' => 2, 'required' => 3, 'reward' => '25€', 'value' => 25, 'label' => '2 weitere Empfehlungen'],
            ['level' => 3, 'required' => 6, 'reward' => '35€', 'value' => 35, 'label' => '3 weitere Empfehlungen'],
            ['level' => 4, 'required' => 10, 'reward' => '45€', 'value' => 45, 'label' => '4 weitere Empfehlungen'],
            ['level' => 5, 'required' => 15, 'reward' => '55€', 'value' => 55, 'label' => '5 weitere Empfehlungen'],
            ['level' => 6, 'required' => 21, 'reward' => '65€', 'value' => 65, 'label' => '6 weitere Empfehlungen'],
            ['level' => 7, 'required' => 28, 'reward' => '75€', 'value' => 75, 'label' => '7 weitere Empfehlungen'],
        ];

        // Calculate total earned
        $earnedTotal = 0;
        for ($i = 1; $i <= $currentLevel; $i++) {
            $earnedTotal += $levels[$i]['value'];
        }

        // Next level logic
        $nextLevel = $currentLevel < 7 ? $levels[$currentLevel + 1] : null;
        $needed = $nextLevel ? $nextLevel['required'] : 0;
        $prevReq = $levels[$currentLevel]['required'];
        
        // Progress
        $progress = 0;
        if ($nextLevel) {
            $totalNeededForNext = $nextLevel['required'] - $prevReq;
            $achievedForNext = $approvedCount - $prevReq;
            if ($totalNeededForNext > 0) {
                $progress = ($achievedForNext / $totalNeededForNext) * 100;
            }
            $progress = min(100, max(5, $progress));
        } else {
            $progress = 100;
        }

        return view('gutscheine', compact('currentLevel', 'levels', 'earnedTotal', 'approvedCount', 'nextLevel', 'progress', 'needed'));
    }
}
