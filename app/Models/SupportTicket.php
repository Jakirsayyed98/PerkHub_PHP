<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class SupportTicket extends Model
{
    use HasFactory;

    protected $table = 'support_tickets';

    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'order_id',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status' => 'string',
    ];

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

    public static function findAllTickets()
    {
        return self::query()->orderByDesc('created_at')->get();
    }

    public static function findTicketById($id)
    {
        return self::find($id);
    }

    public static function addOrUpdateTicket($data)
    {
        try {
            $ticket = self::updateOrCreate(
                ['id' => $data['id'] ?? null],
                [
                    'user_id' => $data['user_id'] ?? null,
                    'subject' => $data['subject'] ?? '',
                    'description' => $data['description'] ?? '',
                    'order_id' => $data['order_id'] ?? null,
                    'status' => $data['status'] ?? 'open',
                ]
            );

            return $ticket;
        } catch (\Exception $e) {
            Log::error('Failed to create/update ticket', ['error' => $e->getMessage()]);
            return false;
        }
    }

    public static function deleteTicket($id)
    {
        $ticket = self::find($id);
        if ($ticket) {
            return $ticket->delete();
        }
        return false;
    }
}