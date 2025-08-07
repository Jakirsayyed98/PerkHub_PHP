<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function createTicket(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'order_id' => 'nullable|exists:orders,id',
        ]);

        try {
            $ticket = SupportTicket::createTicket(
                Auth::id(),
                $validated['subject'],
                $validated['description'],
                $validated['order_id']
            );

            if (!$ticket) {
                Log::error('Ticket creation failed.', ['data' => $validated]);
                return response()->json(['error' => 'Ticket could not be created.'], 500);
            }

            return response()->json(['message' => 'Ticket created successfully.', 'ticket' => $ticket], 201);
        } catch (\Exception $e) {
            Log::error('Exception in ticket creation', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
        }
    }

    public function getUserTickets(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $tickets = SupportTicket::getUserTickets(Auth::id(), $perPage);
        return response()->json(['tickets' => $tickets], 200);
    }

    public function getUserTicketById(Request $request, $id)
    {
        $ticket = SupportTicket::getUserTicketById(Auth::id(), $id);
        if ($ticket) {
            return response()->json(['ticket' => $ticket], 200);
        }
        return response()->json(['error' => 'Ticket not found.'], 404);
    }
}