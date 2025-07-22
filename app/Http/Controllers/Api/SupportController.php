<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\SupportTicket;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    /**
     * Create a support ticket
     */
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

        $ticket = SupportTicket::createTicket(
            $user->id,
            $request->subject,
            $request->description,
            $request->order_id
        );

        return ApiResponse::success(
            $ticket,
            'Support ticket created successfully'
        );
    }

    /**
     * List user's support tickets
     */
    public function listTickets(Request $request)
    {
        $tickets = SupportTicket::getUserTickets($request->user()->id, 20);

        return ApiResponse::success(
            $tickets,
            'Support tickets retrieved successfully'
        );
    }

    /**
     * Show specific support ticket
     */
    public function showTicket(Request $request, $id)
    {
        $ticket = SupportTicket::getUserTicketById($request->user()->id, $id);

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
}