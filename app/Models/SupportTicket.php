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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class, 'support_ticket_id', 'id');
    }

    public static function createTicket($userId, $subject, $description, $orderId = null)
    {
        try {
            return self::create([
                'user_id' => $userId,
                'subject' => $subject,
                'description' => $description,
                'order_id' => $orderId,
                'status' => 'open',
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create ticket', ['error' => $e->getMessage()]);
            return false;
        }
    }

    public static function getUserTickets($userId, $perPage = 10)
    {
        return self::where('user_id', $userId)
            ->with('replies')
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public static function getUserTicketById($userId, $ticketId)
    {
        return self::where('user_id', $userId)
            ->where('id', $ticketId)
            ->with('replies')
            ->first();
    }

    public static function findAllTickets($status = null)
    {
        $query = self::query()->with('user', 'order', 'replies');
        if ($status) {
            $query->where('status', $status);
        }
        return $query->orderByDesc('created_at')->get();
    }

    public static function findTicketById($id)
    {
        return self::with('user', 'order', 'replies')->find($id);
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

    public function resolve()
    {
        $this->status = 'resolved';
        return $this->save();
    }

    public function reopen()
    {
        $this->status = 'open';
        return $this->save();
    }
}