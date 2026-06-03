@extends('layout.main')

@section('content')
    <div class="form-container" style="max-width: 500px;">
        <h1 style="margin-bottom: 5px;">Admin Login</h1>
        <p class="subtitle">Enter your credentials to access the ticket dashboard</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.login.process') }}" method="POST" class="ticket-form">
            @csrf
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" class="form-control @error('email') error @enderror" required value="{{ old('email') }}" placeholder="admin@.com">
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control @error('password') error @enderror" required>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-lg">Login</button>
        </form>

        <div style="text-align: center; margin-top: 30px; padding: 20px; background-color: #f0f4ff; border-radius: 8px;">
            <p style="color: var(--text-dark); font-size: 13px; font-weight: 600; margin-bottom: 8px;">Demo Credentials:</p>
            <p style="color: var(--text-light); font-size: 13px; margin: 4px 0;">Email: <strong>admin@example.com</strong></p>
            <p style="color: var(--text-light); font-size: 13px; margin: 4px 0;">Password: <strong>admin123</strong></p>
        </div>
    </div>
@endsection