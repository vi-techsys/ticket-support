<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;

class TicketController extends Controller
{
    public function index()
    {
        return view('tickets.create');
    }

    public function store(TicketRequest $request)
    {
        $data = $request->validated();
        
        // here I generate unique ticket ID
        $ticketId = 'TKT' . strtoupper(uniqid());
        
        $ticket = [
            'ticket_id' => $ticketId,
            'name' => $data['fullname'],
            'email' => $data['email'],
            'title' => $data['ticket_title'],
            'description' => $data['ticket_description'],
            'status' => 'Open'
        ];

        $filePath = storage_path('tickets.json');
        $tickets = [];
        
        // Load existing tickets
        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
            if (!empty($content)) {
                $tickets = json_decode($content, true) ?? [];
            }
        }

        // Add new ticket
        $tickets[] = $ticket;

        // Save back as proper JSON array
        file_put_contents($filePath, json_encode($tickets, JSON_PRETTY_PRINT));

        return redirect()->route('home')
            ->with('success', 'Ticket submitted successfully!')
            ->with('ticketId', $ticketId);
    }
}
