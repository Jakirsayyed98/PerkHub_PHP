<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $fillable = ['uuid', 'name', 'email', 'mobile', 'password'];

    protected $hidden = ['password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(WithdrawalRequest::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public static function findOrCreateByMobile($mobile)
    {
        $user = self::where('mobile', $mobile)->first();
        if (!$user) {
            $user = self::create([
                'uuid' => \Illuminate\Support\Str::uuid(),
                'mobile' => $mobile,
                'name' => 'User_' . substr($mobile, -4),
            ]);
        }
        return $user;
    }

    public static function findByMobile($mobile)
    {
        return self::where('mobile', $mobile)->first();
    }

    public function generateJwtToken()
    {
        return \Tymon\JWTAuth\Facades\JWTAuth::fromUser($this);
    }

    public static function updateProfile($userId, $data)
    {
        $user = self::find($userId);
        if (!$user) {
            return null;
        }
        $user->update(array_filter($data)); // Only update non-null fields
        return $user;
    }

    public static function getUsers($perPage)
    {
        return self::select('id', 'uuid', 'name', 'email', 'mobile', 'created_at')
            ->paginate($perPage);
    }

    public static function getUserById($id)
    {
        return self::select('id', 'uuid', 'name', 'email', 'mobile', 'created_at')
            ->where('id', $id)
            ->first();
    }

    public static function hasPendingWithdrawal($userId)
    {
        return WithdrawalRequest::where('user_id', $userId)
            ->where('status', 'pending')
            ->exists();
    }

    public static function getAvailableBalance($userId)
    {
        return self::where('id', $userId)
            ->with('wallet')
            ->first()
            ->wallet->balance ?? 0;
    }

    public static function getApprovedEarnings($userId)
    {
        return Transaction::where('user_id', $userId)
            ->where('type', 'credit')
            ->where('status', 'approved')
            ->sum('amount');
    }

    public static function getWithdrawnAmount($userId)
    {
        return WithdrawalRequest::where('user_id', $userId)
            ->where('status', 'approved')
            ->sum('amount');
    }

    public static function getRejectedEarnings($userId)
    {
        return Transaction::where('user_id', $userId)
            ->where('type', 'credit')
            ->where('status', 'rejected')
            ->sum('amount');
    }

    public static function getPendingEarnings($userId)
    {
        return Transaction::where('user_id', $userId)
            ->where('type', 'credit')
            ->where('status', 'pending')
            ->sum('amount');
    }
}