<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\ApiResponse;
use App\Models\SupportTicket;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SupportTicketController extends Controller
{
    public function index()
    {
        Log::info('Tickets index accessed');
        if (view()->exists('admin.tickets.index')) {
            return view('admin.tickets.index');
        }
        Log::error('View admin.tickets.index not found');
        return response('View not found', 500);
    }

    public function apiIndex(Request $request)
    {
        Log::info('API tickets accessed');
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

        $tickets = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return ApiResponse::success($tickets, 'Support tickets retrieved successfully');
    }

    public function edit($id)
    {
        Log::info("Tickets edit accessed for ID: $id");
        try {
            $ticket = SupportTicket::findOrFail($id);
            if (view()->exists('admin.tickets.edit')) {
                return view('admin.tickets.edit', compact('ticket'));
            }
            Log::error('View admin.tickets.edit not found');
            return response('View not found', 500);
        } catch (\Exception $e) {
            Log::error('Tickets edit error: ' . $e->getMessage());
            return redirect()->route('admin.tickets.index')->with('error', 'Ticket not found');
        }
    }

    public function update(Request $request, $id)
    {
        Log::info("Updating ticket ID: $id");
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