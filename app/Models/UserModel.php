<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject; // This must be imported


class UserModel extends Model implements JWTSubject
{
    use HasFactory;

    public $table ="user_tbl";

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'phone_number',
        'otp',
        'is_verified',
        'is_active',
        'is_deleted',
        'created_at',
        'updated_at',
    ];

    public function getUserByUserId($user_id)
    {
        return self::where('user_id', $user_id)->first();
    }


    public function getAllUsers()
    {
        return self::where('status', '1')->get();
    }

    /**
     * Get the identifier that will be stored in the JWT.
     * 
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        // This should return the unique identifier of the user
        return $this->user_id; // or $this->id, depending on your primary key
    }

    /**
     * Return custom claims to include in the JWT.
     * 
     * @return array
     */
    public function getJWTCustomClaims()
    {
        // This is where you can add any custom claims, like roles or permissions
        return [];
    }
}
