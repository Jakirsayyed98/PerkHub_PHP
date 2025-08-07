<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupportTicketsController extends Controller
{
    public function adminTicketList(Request $request)
    {
        $ticketList = SupportTicket::findAllTickets();
        return view('adminpanel.tickets.custometicketlist', compact('ticketList'));
    }

    public function CreateTicketAndUpdate(Request $request)
    {
        $ticket = $request->id ? SupportTicket::findTicketById($request->id) : null;
        return view('adminpanel.tickets.createandupdateticket', compact('ticket'));
    }

    public function deleteTicketProcess(Request $request, $id)
    {
        $result = SupportTicket::deleteTicket($id);
        if ($result) {
            return redirect()->route('admin.ticket.list')->with('success', 'Ticket deleted successfully.');
        }
        return redirect()->route('admin.ticket.list')->with('error', 'Ticket not found or could not be deleted.');
    }

    public function createandupdateticketprocess(Request $request)
    {
        $validated = $request->validate([
            'id' => 'nullable|exists:support_tickets,id',
            'user_id' => 'nullable|exists:users,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'order_id' => 'nullable|exists:orders,id',
            'status' => 'nullable|in:open,in_progress,resolved',
        ]);

        try {
            $result = SupportTicket::addOrUpdateTicket($validated);

            if (!$result) {
                Log::error('Ticket updateOrCreate failed.', ['data' => $validated]);
                return back()->with('error', 'Ticket could not be saved.');
            }

            return redirect()->route('admin.ticket.list')->with('success', 'Ticket saved successfully.');
        } catch (\Exception $e) {
            Log::error('Exception in ticket process', ['error' => $e->getMessage()]);
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}