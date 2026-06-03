@extends('layout.main')

@section('content')
    <div class="form-container" style="max-width: 500px;">
        <h1 style="margin-bottom: 5px;">Create Admin Account</h1>
        <p class="subtitle">Register to manage support tickets</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.register.process') }}" method="POST" class="ticket-form">
            @csrf
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') error @enderror" required value="{{ old('name') }}">
                @error('name')
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
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control @error('password') error @enderror" required>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary btn-lg">Create Account</button>
        </form>

        <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border-color);">
            <p style="color: var(--text-light); font-size: 14px;">Already have an account? <a href="{{ route('admin.login') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Login here</a></p>
        </div>
    </div>
@endsection