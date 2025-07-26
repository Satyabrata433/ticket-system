<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\SystemSetting;
use App\Models\TicketAttachment;
use App\Models\TicketNote;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    // List all tickets with formatted ID
    public function index()
    {
        $prefix = SystemSetting::first()->id_prefix ?? 'TKT-';
        $tickets = Ticket::all();

        $tickets = $tickets->map(function ($ticket, $index) use ($prefix) {
            return [
                'id' => '#' . $prefix . now()->year . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'service' => $ticket->service,
                'customer' => $ticket->customer,
                'partner' => $ticket->partner,
                'date_created' => $ticket->date_created,
                'status' => $ticket->status,
            ];
        });

        return response()->json($tickets);
    }

    // Show full ticket details
    public function show($id)
    {
        $ticket = Ticket::with(['attachments', 'notes'])->find($id);

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $prefix = SystemSetting::first()->id_prefix ?? 'TKT-';

        $formattedId = '#' . $prefix . now()->year . '-' . substr($ticket->id, -3); // Example formatting

        return response()->json([
            'id' => $formattedId,
            'service' => $ticket->service,
            'customer' => $ticket->customer,
            'partner' => $ticket->partner,
            'date_created' => $ticket->date_created,
            'status' => $ticket->status,
            'attachments' => $ticket->attachments,
            'notes' => $ticket->notes,
        ]);
    }

    // Upload attachment for ticket
    public function uploadAttachment(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $request->validate([
            'attachment' => 'required|file|mimes:jpeg,png,pdf,doc,docx|max:10240', // max 10MB
        ]);

        $file = $request->file('attachment');
        $path = $file->store('attachments');

        $attachment = TicketAttachment::create([
            'ticket_id' => $ticket->id,
            'file_name' => $file->getClientOriginalName(),
            'file_path' => $path,
        ]);

        return response()->json(['message' => 'Attachment uploaded', 'attachment' => $attachment], 201);
    }

    // Add note to ticket
    public function addNote(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $request->validate([
            'user_name' => 'required|string|max:100',
            'note' => 'required|string',
        ]);

        $note = TicketNote::create([
            'ticket_id' => $ticket->id,
            'user_name' => $request->user_name,
            'note' => $request->note,
        ]);

        return response()->json(['message' => 'Note added', 'note' => $note], 201);
    }
}
