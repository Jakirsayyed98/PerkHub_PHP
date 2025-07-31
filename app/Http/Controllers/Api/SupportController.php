<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ApiResponse;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    public function createTicket(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:2000',
            'order_id' => 'nullable|exists:orders,id,user_id,' . $user->id,
        ]);

        if ($validator->fails()) {
            return ApiResponse::error(
                'Validation failed',
                $validator->errors(),
                422,
                'VALIDATION_FAILED'
            );
        }

        $ticket = SupportTicket::create([
            'user_id' => $user->id,
            'subject' => $request->subject,
            'description' => $request->description,
            'order_id' => $request->order_id,
            'status' => 'open',
        ]);

        return ApiResponse::success(
            $ticket,
            'Support ticket created successfully'
        );
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $status = $request->input('status');

        $query = SupportTicket::where('user_id', Auth::id());

        if ($status) {
            $query->where('status', $status);
        }

        $tickets = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return ApiResponse::success(
            $tickets,
            'Support tickets retrieved successfully'
        );
    }

    public function show(Request $request, $id)
    {
        $ticket = SupportTicket::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$ticket) {
            return ApiResponse::error(
                'Ticket not found or not authorized',
                [],
                404,
                'TICKET_NOT_FOUND'
            );
        }

        return ApiResponse::success(
            $ticket,
            'Support ticket retrieved successfully'
        );
    }

    public function closeTicket(Request $request, $id)
    {
        $ticket = SupportTicket::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if (!$ticket) {
            return ApiResponse::error(
                'Ticket not found or not authorized',
                [],
                404,
                'TICKET_NOT_FOUND'
            );
        }

        $ticket->update(['status' => 'resolved']);

        return ApiResponse::success(
            $ticket,
            'Support ticket closed successfully'
        );
    }
}