<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'iban',
        'birth_date',
        'password',
        'referral_code',
        'full_name',
        'offer_accepted',
        'current_provider', 'current_tariff', 'current_location', 'current_consumption',
        'current_months', 'current_working_price', 'current_basic_price', 'current_total',
        'new_provider', 'new_tariff', 'new_location', 'new_consumption',
        'new_months', 'new_working_price', 'new_basic_price', 'new_total',
        'savings_year1_eur', 'savings_year1_percent', 'savings_year2_eur', 'savings_year2_percent',
        'savings_max_eur', 'savings_max_percent'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->referral_code)) {
                // Generate: First 3 letters of name + random number
                // Remove non-alphanumeric chars from name
                $cleanName = preg_replace('/[^a-zA-Z0-9]/', '', $user->name);
                $prefix = substr(strtoupper($cleanName), 0, 3);
                
                // Pad if less than 3 chars
                if (strlen($prefix) < 3) {
                    $prefix = str_pad($prefix, 3, 'X');
                }
                
                $user->referral_code = $prefix . rand(100000, 999999);
            }
        });
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

    public function referrer()
    {
        return $this->hasOne(Referral::class, 'referred_user_id');
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getLevelAttribute()
    {
        $count = $this->referrals()->where('status', 2)->count(); // Only approved count

        // Thresholds
        if ($count >= 50) return 7;
        if ($count >= 30) return 6;
        if ($count >= 20) return 5;
        if ($count >= 10) return 4;
        if ($count >= 5) return 3;
        if ($count >= 3) return 2;
        if ($count >= 1) return 1;
        
        return 0;
    }
}
