<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\WithdrawalRequest;



class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'mobile',
        'name',
        'email',
        'gender',
        'dob',
        'is_verified',
        'referral_code',
        'referred_by',
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'dob' => 'date',
        'is_verified' => 'boolean',
    ];

    /**
     * Boot method to generate custom UUID-based user_id
     */
    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->user_id)) {
                $user->user_id = strtoupper(Str::random(12));
            }

            if (empty($user->referral_code)) {
                $user->referral_code = strtoupper(Str::random(8));
            }
        });
    }

    public function generateJwtToken()
    {
        return JWTAuth::fromUser($this, ['exp' => now()->addMinutes(15)->timestamp]);
    }

    /**
     * Relationships
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(WithdrawalRequest::class);
    }

    /**
     * Helper: Create or get user by mobile
     */
    public static function findOrCreateByMobile($mobile)
    {
        return self::firstOrCreate(
            ['mobile' => $mobile],
            [
                'name' => null,
                'email' => null,
                'gender' => 'male',
                'dob' => null,
                'is_verified' => true,
                'referred_by' => null,
            ]
        );
    }

    /**
     * JWT: Identifier
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * JWT: Custom claims
     */
    public function getJWTCustomClaims()
    {
        return [
            'user_id' => $this->user_id,
            'mobile' => $this->mobile,
        ];
    }

    /**
     * Financial summary methods
     */
    public function approvedEarnings()
    {
        return $this->transactions()->approved()->sum('user_commission');
    }

    public function rejectedEarnings()
    {
        return $this->transactions()->rejected()->sum('user_commission');
    }

    public function pendingEarnings()
    {
        return $this->transactions()->pending()->sum('user_commission');
    }

    public function withdrawnAmount()
    {
        return $this->withdrawals()->approved()->sum('amount');
    }

    public function availableBalance()
    {
        return $this->approvedEarnings()
            - $this->withdrawals()->whereIn('status', ['approved', 'pending'])->sum('amount');
    }

    public function hasPendingWithdrawalRequest()
    {
        return $this->withdrawals()->where('status', 'pending')->exists();
    }

    public function hasRecentWithdrawalRequest()
    {
        return $this->withdrawals()
            ->orderByDesc('created_at')
            ->first()?->created_at > now()->subHour();
    }
}
