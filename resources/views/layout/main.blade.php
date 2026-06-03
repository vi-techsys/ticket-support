<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ticket Support System</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --secondary-color: #6c757d;
            --success-color: #10b981;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
            --info-color: #3b82f6;
            --light-bg: #f3f4f6;
            --border-color: #e5e7eb;
            --text-dark: #1f2937;
            --text-light: #6b7280;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 0 40px;
        }

        header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        header ul {
            list-style: none;
            display: flex;
            gap: 30px;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            height: 60px;
            flex-wrap: wrap;
        }

        header a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            transition: color 0.3s;
            font-size: 14px;
        }

        header a:hover {
            color: var(--primary-color);
        }

        main {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .form-container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-container h1 {
            font-size: 28px;
            margin-bottom: 10px;
            color: var(--text-dark);
        }

        .subtitle {
            color: var(--text-light);
            margin-bottom: 30px;
            font-size: 14px;
        }

        .ticket-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 14px;
        }

        .form-control {
            padding: 12px 14px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-control.error {
            border-color: var(--danger-color);
        }

        .error-text {
            color: var(--danger-color);
            font-size: 12px;
            margin-top: 4px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 14px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.3);
        }

        .btn-lg {
            padding: 14px 32px;
            font-size: 16px;
            width: 100%;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 12px;
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #7f1d1d;
            border: 1px solid #fca5a5;
        }

        /* Admin Dashboard Styles */
        .admin-container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--light-bg);
            padding-bottom: 20px;
        }

        .admin-header h1 {
            font-size: 28px;
            color: var(--text-dark);
        }

        .ticket-count {
            font-size: 16px;
            color: var(--text-light);
        }

        .ticket-count span {
            font-weight: bold;
            color: var(--primary-color);
            font-size: 20px;
        }

        .tickets-table-wrapper {
            overflow-x: auto;
        }

        .tickets-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        .tickets-table thead {
            background-color: var(--light-bg);
        }

        .tickets-table th {
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: var(--text-dark);
            border-bottom: 2px solid var(--border-color);
        }

        .tickets-table td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .ticket-row:hover {
            background-color: var(--light-bg);
        }

        .ticket-id {
            font-family: monospace;
            font-weight: 600;
            color: var(--primary-color);
        }

        .ticket-title {
            font-weight: 500;
            max-width: 200px;
        }

        .ticket-desc {
            color: var(--text-light);
            max-width: 200px;
        }

        .desc-preview {
            display: inline-block;
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
        }

        .status-open {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-in\ progress {
            background-color: #fed7aa;
            color: #92400e;
        }

        .status-resolved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .date-cell {
            color: var(--text-light);
            font-size: 13px;
        }

        .actions-cell {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 12px;
            transition: all 0.3s;
        }

        .btn-view {
            background-color: var(--info-color);
            color: white;
        }

        .btn-view:hover {
            background-color: #2563eb;
            transform: translateY(-1px);
        }

        .btn-delete {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-delete:hover {
            background-color: #dc2626;
            transform: translateY(-1px);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }

        .empty-state h2 {
            font-size: 24px;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--text-light);
            font-size: 16px;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-content {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-header h2 {
            font-size: 22px;
            color: var(--text-dark);
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: var(--text-light);
            transition: color 0.3s;
        }

        .modal-close:hover {
            color: var(--text-dark);
        }

        .modal-body {
            padding: 30px;
        }

        .ticket-details {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .detail-row {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .detail-row label {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .detail-row span {
            color: var(--text-light);
            font-size: 14px;
            line-height: 1.6;
            word-break: break-word;
        }

        .status-controls {
            display: flex;
            gap: 10px;
        }

        .status-select {
            flex: 1;
            padding: 10px 12px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .status-select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        @media (max-width: 768px) {
            header ul {
                gap: 15px;
                font-size: 12px;
            }

            main {
                margin: 20px auto;
            }

            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .tickets-table {
                font-size: 12px;
            }

            .tickets-table th,
            .tickets-table td {
                padding: 10px;
            }

            .actions-cell {
                flex-wrap: wrap;
            }

            .btn-action {
                padding: 4px 8px;
                font-size: 10px;
            }

            .form-container {
                padding: 30px 20px;
            }

            .modal-content {
                max-width: 95%;
            }

            .modal-body {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <header>
        <ul>
            <li><a href="{{ route('home') }}">➕ Create Ticket</a></li>
            @if(!session()->has('admin'))
                <li style="margin-left: auto;"><a href="{{ route('admin.login') }}">🔐 Admin Login</a></li>
            @else
                <li style="margin-left: auto; display: flex; gap: 15px; align-items: center;">
                    <span style="color: var(--text-light); font-size: 14px;">👤 Admin</span>
                    <form action="{{ route('admin.logout') }}" method="POST" style="display:inline; margin: 0;">
                        @csrf
                        <button type="submit" style="background: none; border: none; cursor: pointer; color: var(--text-dark); font-weight: 500; font-size: 14px;">🚪 Logout</button>
                    </form>
                </li>
            @endif
        </ul>
    </header>

    <main>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>

    @yield('scripts')
    
    <script>
        // Auto-hide alert messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s ease-out';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>