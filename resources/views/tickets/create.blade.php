@extends('layout.main')
@section('content')
<div class="form-container">
    <h1>Create a Support Ticket</h1>
    <p class="subtitle">Submit your ticket and our team will get back to you shortly</p>
    
    @if(session('ticketId'))
        <div style="background-color: #d1fae5; border: 2px solid #10b981; border-radius: 8px; padding: 20px; margin-bottom: 30px;">
            <p style="color: #065f46; font-size: 14px; margin-bottom: 8px; font-weight: 600;">✓ Ticket Created Successfully!</p>
            <p style="color: #047857; font-size: 16px; margin: 0;">Your Ticket ID: <span style="font-weight: 700; font-family: monospace; font-size: 18px;">{{ session('ticketId') }}</span></p>
            <p style="color: #065f46; font-size: 13px; margin-top: 8px;">Please save this ID for your records.</p>
        </div>
    @endif
    
    <form action="{{ route('tickets.store') }}" method="POST" class="ticket-form">
        @csrf
        
        <div class="form-group">
            <label for="fullname">Full Name</label>
            <input type="text" name="fullname" id="fullname" class="form-control @error('fullname') error @enderror" required value="{{ old('fullname') }}">
            @error('fullname')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" class="form-control @error('email') error @enderror" required value="{{ old('email') }}">
            @error('email')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="ticket_title">Ticket Title</label>
            <input type="text" name="ticket_title" id="ticket_title" class="form-control @error('ticket_title') error @enderror" required value="{{ old('ticket_title') }}" placeholder="Brief subject of your issue">
            @error('ticket_title')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="ticket_description">Ticket Description</label>
            <textarea name="ticket_description" id="ticket_description" class="form-control @error('ticket_description') error @enderror" rows="6" required placeholder="Please describe your issue in detail">{{ old('ticket_description') }}</textarea>
            @error('ticket_description')
                <span class="error-text">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-lg">Submit Ticket</button>
    </form>
</div>
@endsection