<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketReply extends Model
{
    use HasFactory;

    protected $table = 'ticket_replies';

    protected $fillable = [
        'support_ticket_id',
        'admin_id',
        'message',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    public function supportTicket()
    {
        return $this->belongsTo(SupportTicket::class, 'support_ticket_id', 'id');
    }

    public static function createReply($ticketId, $adminId, $message)
    {
        try {
            return self::create([
                'support_ticket_id' => $ticketId,
                'admin_id' => $adminId,
                'message' => $message,
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create ticket reply', ['error' => $e->getMessage()]);
            return false;
        }
    }
}