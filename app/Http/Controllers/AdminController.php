<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        if (!session()->has('admin')) {
            return redirect()->route('admin.login')->with('error', 'Please login first');
        }

        $tickets = [];
        $filePath = storage_path('tickets.json');
        
        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
            if (!empty($content)) {
                $tickets = json_decode($content, true) ?? [];
            }
        }

        return view('admin.tickets', compact('tickets'));
    }

    public function updateStatus(Request $request, $ticketId)
    {
        if (!session()->has('admin')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'status' => 'required|in:Open,Resolved'
        ]);

        $filePath = storage_path('tickets.json');
        $tickets = [];

        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
            if (!empty($content)) {
                $tickets = json_decode($content, true) ?? [];
            }
        }

        // Find and update ticket
        foreach ($tickets as $key => $ticket) {
            if ($ticket['ticket_id'] == $ticketId) {
                $tickets[$key]['status'] = $request->input('status');
                break;
            }
        }

        file_put_contents($filePath, json_encode($tickets, JSON_PRETTY_PRINT));

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Ticket updated']);
        }

        return redirect()->route('admin.dashboard')->with('success', 'Ticket updated successfully!');
    }

}
