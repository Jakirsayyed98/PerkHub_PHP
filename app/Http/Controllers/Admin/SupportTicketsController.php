<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SupportTicketsController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $ticketList = SupportTicket::findAllTickets($status);
        return view('adminpanel.tickets.custometicketlist', compact('ticketList'));
    }

    public function closed(Request $request)
    {
        $ticketList = SupportTicket::findAllTickets('resolved');
        return view('adminpanel.tickets.custometicketlist', compact('ticketList'));
    }

    public function show(Request $request, SupportTicket $ticket)
    {
        $ticket->load('user', 'order', 'replies.admin');
        return view('adminpanel.tickets.ticketdetails', compact('ticket'));
    }

    public function CreateTicketAndUpdate(Request $request,$id = null)
    {

        $ticket = $id ? SupportTicket::findTicketById($id) : null;
        return view('adminpanel.Support.createandupdateticket', compact('ticket'));
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

    public function reply(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        try {
            $reply = TicketReply::createReply(
                $ticket->id,
                Auth::guard('admin')->id(),
                $validated['message']
            );

            if (!$reply) {
                Log::error('Ticket reply creation failed.', ['ticket_id' => $ticket->id]);
                return back()->with('error', 'Reply could not be added.');
            }

            return back()->with('success', 'Reply added successfully.');
        } catch (\Exception $e) {
            Log::error('Exception in ticket reply', ['error' => $e->getMessage()]);
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function resolve(Request $request, SupportTicket $ticket)
    {
        try {
            $result = $ticket->resolve();

            if (!$result) {
                Log::error('Ticket resolve failed.', ['ticket_id' => $ticket->id]);
                return back()->with('error', 'Ticket could not be resolved.');
            }

            return redirect()->route('admin.ticket.list')->with('success', 'Ticket resolved successfully.');
        } catch (\Exception $e) {
            Log::error('Exception in ticket resolve', ['error' => $e->getMessage()]);
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function reopen(Request $request, SupportTicket $ticket)
    {
        try {
            $result = $ticket->reopen();

            if (!$result) {
                Log::error('Ticket reopen failed.', ['ticket_id' => $ticket->id]);
                return back()->with('error', 'Ticket could not be reopened.');
            }

            return redirect()->route('admin.ticket.list')->with('success', 'Ticket reopened successfully.');
        } catch (\Exception $e) {
            Log::error('Exception in ticket reopen', ['error' => $e->getMessage()]);
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function deleteTicketProcess(Request $request, $id)
    {
        $result = SupportTicket::deleteTicket($id);
        if ($result) {
            return redirect()->route('admin.ticket.list')->with('success', 'Ticket deleted successfully.');
        }
        return redirect()->route('admin.ticket.list')->with('error', 'Ticket not found or could not be deleted.');
    }
}