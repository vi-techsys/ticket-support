<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;


// Public routes - Ticket creation for guests
Route::get('/', [TicketController::class, 'index'])->name('home');
Route::post('/save-tickets', [TicketController::class, 'store'])->name('tickets.store');

// Admin routes - Login
Route::get('/admin/login', [AuthController::class, 'adminlogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'processlogin'])->name('admin.login.process');

// Admin routes - Dashboard (protected by session check in controller)
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::patch('/admin/tickets/{ticketId}/status', [AdminController::class, 'updateStatus'])->name('tickets.update');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

