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
        'password',
        'referral_code',
        'full_name',
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
