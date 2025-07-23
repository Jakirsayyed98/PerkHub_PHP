<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = ['user_id', 'subject', 'description', 'order_id', 'status', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public static function createTicket($userId, $subject, $description, $orderId)
    {
        return self::create([
            'user_id' => $userId,
            'subject' => $subject,
            'description' => $description,
            'order_id' => $orderId,
            'status' => 'open',
            'created_at' => now(),
        ]);
    }

    public static function getUserTickets($userId, $perPage)
    {
        return self::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public static function getUserTicketById($userId, $ticketId)
    {
        return self::where('user_id', $userId)
            ->where('id', $ticketId)
            ->first();
    }
}