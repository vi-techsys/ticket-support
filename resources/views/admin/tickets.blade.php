@extends('layout.main')

@section('content')
<div class="admin-container">
    <div class="admin-header">
        <h1>Admin Dashboard - Support Tickets</h1>
        <div style="display: flex; gap: 15px; align-items: center;">
            <p class="ticket-count">Total Tickets: <span>{{ count($tickets) }}</span></p>
            <form action="{{ route('admin.logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-secondary">Logout</button>
            </form>
        </div>
    </div>

    @if(count($tickets) > 0)
        <div class="tickets-table-wrapper">
            <table class="tickets-table">
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr class="ticket-row" data-ticket-id="{{ $ticket['ticket_id'] }}">
                            <td class="ticket-id">{{ $ticket['ticket_id'] }}</td>
                            <td>{{ $ticket['name'] }}</td>
                            <td>{{ $ticket['email'] }}</td>
                            <td class="ticket-title">{{ $ticket['title'] }}</td>
                            <td>
                                <span class="status-badge status-{{ strtolower($ticket['status']) }}">
                                    {{ $ticket['status'] }}
                                </span>
                            </td>
                            <td class="actions-cell">
                                <button class="btn-action btn-view" onclick="viewTicketDetails('{{ $ticket['ticket_id'] }}')">View</button>
                                @if($ticket['status'] !== 'Resolved')
                                    <button class="btn-action btn-resolve" onclick="resolveTicket('{{ $ticket['ticket_id'] }}')">Resolve</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <h2>No Tickets Yet</h2>
            <p>There are no support tickets at the moment.</p>
        </div>
    @endif
</div>

<!-- Modal for ticket details -->
<div id="ticketModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Ticket Details</h2>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body">
            <div class="ticket-details">
                <div class="detail-row">
                    <label>Ticket ID:</label>
                    <span id="detail-ticket-id"></span>
                </div>
                <div class="detail-row">
                    <label>Name:</label>
                    <span id="detail-name"></span>
                </div>
                <div class="detail-row">
                    <label>Email:</label>
                    <span id="detail-email"></span>
                </div>
                <div class="detail-row">
                    <label>Title:</label>
                    <span id="detail-title"></span>
                </div>
                <div class="detail-row">
                    <label>Description:</label>
                    <span id="detail-description" style="white-space: pre-wrap; display: block; background-color: #f5f5f5; padding: 10px; border-radius: 4px; margin-top: 5px;"></span>
                </div>
                <div class="detail-row">
                    <label>Status:</label>
                    <span id="detail-status" class="status-badge"></span>
                </div>
                <div class="detail-row" style="margin-top: 20px; display: flex; gap: 10px;">
                    <button class="btn btn-primary" id="modal-resolve-btn" onclick="resolveFromModal()">Mark Resolved</button>
                    <button class="btn btn-secondary" onclick="closeModal()">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentTicket = null;

    function viewTicketDetails(ticketId) {
        const tickets = @json($tickets);
        currentTicket = tickets.find(t => t.ticket_id === ticketId);
        
        if (currentTicket) {
            document.getElementById('detail-ticket-id').textContent = currentTicket.ticket_id;
            document.getElementById('detail-name').textContent = currentTicket.name;
            document.getElementById('detail-email').textContent = currentTicket.email;
            document.getElementById('detail-title').textContent = currentTicket.title;
            document.getElementById('detail-description').textContent = currentTicket.description;
            
            const statusEl = document.getElementById('detail-status');
            statusEl.textContent = currentTicket.status;
            statusEl.className = `status-badge status-${currentTicket.status.toLowerCase()}`;
            
            // Show/hide resolve button based on status
            const resolveBtn = document.getElementById('modal-resolve-btn');
            if (currentTicket.status === 'Resolved') {
                resolveBtn.style.display = 'none';
            } else {
                resolveBtn.style.display = 'block';
            }
            
            document.getElementById('ticketModal').style.display = 'flex';
        }
    }

    function closeModal() {
        document.getElementById('ticketModal').style.display = 'none';
        currentTicket = null;
    }

    function resolveFromModal() {
        if (currentTicket) {
            resolveTicket(currentTicket.ticket_id);
        }
    }

    function resolveTicket(ticketId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/tickets/${ticketId}/status`;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PATCH';
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = 'Resolved';
        
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = document.querySelector('meta[name="csrf-token"]').content;
        
        form.appendChild(methodInput);
        form.appendChild(statusInput);
        form.appendChild(tokenInput);
        document.body.appendChild(form);
        form.submit();
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('ticketModal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>
@endsection