<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\SupportTicket;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');
        $status = $request->input('status');

        $query = SupportTicket::with(['user' => function ($query) {
            $query->select('id', 'name', 'email', 'mobile');
        }, 'order' => function ($query) {
            $query->select('id', 'user_id', 'store_id', 'order_id', 'status');
        }]);

        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
            })->orWhere('subject', 'like', "%{$search}%");
        }

        if ($status) {
            $query->where('status', $status);
        }

        $tickets = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return ApiResponse::success($tickets, 'Support tickets retrieved successfully');
    }

    public function update(Request $request, $id)
    {
        $ticket = SupportTicket::find($id);
        if (!$ticket) {
            return ApiResponse::error('Ticket not found', [], 404, 'TICKET_NOT_FOUND');
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:open,in_progress,resolved',
            'admin_note' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422, 'VALIDATION_FAILED');
        }

        $ticket->update([
            'status' => $request->status,
            'admin_note' => $request->admin_note,
        ]);

        Notification::create([
            'user_id' => $ticket->user_id,
            'title' => 'Support Ticket Updated',
            'message' => "Your support ticket #{$ticket->id} has been updated to {$request->status}.",
            'type' => 'user_specific',
        ]);

        return ApiResponse::success($ticket, 'Support ticket updated successfully');
    }
}