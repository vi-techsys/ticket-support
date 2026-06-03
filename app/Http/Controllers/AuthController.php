<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Hardcoded admin credentials with hashed password
    private const ADMIN_EMAIL = 'admin@example.com';
    // This is the bcrypt hash of "admin123"
    private const ADMIN_PASSWORD = 'admin123';

    public function adminlogin()
    {
        if (session()->has('admin')) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function processlogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        //hash password
        $hashedPassword = password_hash(self::ADMIN_PASSWORD, PASSWORD_DEFAULT);
        // Check credentials using password_verify
        if ($email === self::ADMIN_EMAIL && password_verify($password, $hashedPassword)) {
            session(['admin' => $email]);
            return redirect()->route('admin.dashboard')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    /*
        public function register(){
            return view('auth.register');
        }

        public function saveadmin(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return redirect()->route('admin.login')->with('success', 'Registration successful! Please log in.');    
        }

        */
    public function logout()
    {
        session()->forget('admin');
        return redirect()->route('admin.login')->with('success', 'Logged out successfully!');
    }
}
