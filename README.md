# PostGuy - Ticket Support System

A lightweight Laravel-based ticket support system where guests can create support tickets and admins can manage them.

## Features

- **Guest Ticket Creation** - Simple form to submit support tickets with name, email, title, and description
- **Unique Ticket IDs** - Auto-generated tracking IDs (format: TKT + unique identifier)
- **Admin Dashboard** - View all tickets in a clean table with color-coded status badges
- **Status Management** - Update ticket status from Open to Resolved
- **Persistent Storage** - All tickets saved to JSON file (no database needed)
- **Session Authentication** - Hardcoded admin credentials with bcrypt password verification
- **Responsive Design** - Mobile-friendly interface with custom CSS
- **Modal Details** - View full ticket information including complete descriptions

## Getting Started

1. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Start the development server**
   ```bash
   php artisan serve
   ```

3. **Access the app**
   - Guest tickets: `http://localhost:8000`
   - Admin login: `http://localhost:8000/admin/login`
   - Demo credentials: `admin@postguy.com` / `admin123`

## How It Works

- **Guests**: Fill out the ticket form and receive a unique ticket ID to track their request
- **Admin**: Login to view all tickets, see full details in a modal, and update ticket status
- **Storage**: All data stored in `storage/tickets.json`

## Tech Stack

- Laravel 11/13
- PHP 8.x
- Custom CSS (responsive design)
- JavaScript (modal interactions)
- Blade templating

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
