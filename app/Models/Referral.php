<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referrer_id', 'referred_user_id', 'status',
        'current_provider', 'current_tariff', 'current_location', 'current_consumption',
        'current_months', 'current_working_price', 'current_basic_price', 'current_total',
        'new_provider', 'new_tariff', 'new_location', 'new_consumption',
        'new_months', 'new_working_price', 'new_basic_price', 'new_total',
        'savings_year1_eur', 'savings_year1_percent', 'savings_year2_eur', 'savings_year2_percent',
        'savings_max_eur', 'savings_max_percent'
    ];
    
    protected $casts = [
        'current_working_price' => 'decimal:2',
        'current_basic_price' => 'decimal:2',
        'current_total' => 'decimal:2',
        'new_working_price' => 'decimal:2',
        'new_basic_price' => 'decimal:2',
        'new_total' => 'decimal:2',
        'savings_year1_eur' => 'decimal:2',
        'savings_year1_percent' => 'decimal:2',
        'savings_year2_eur' => 'decimal:2',
        'savings_year2_percent' => 'decimal:2',
        'savings_max_eur' => 'decimal:2',
        'savings_max_percent' => 'decimal:2',
    ];

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
}
