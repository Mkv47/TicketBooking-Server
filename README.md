# TicketBooking Project

## Overview
This is a Laravel-based ticket booking application with features including booking management, admin dashboard, email notifications, and Stripe payment integration (sandbox). It supports promo codes, client-side validation, and admin authentication.

---

## Requirements
- PHP 8.x
- Composer
- MySQL
- Node.js & npm (for frontend assets)
- Laravel 10.x (tested)
- Mailtrap account for email testing
- Stripe sandbox account for payment simulation

---

## Setup Instructions

### 1. Clone the Repository
```bash
git clone <https://github.com/Mkv47/TicketBooking-Server.git>     // or dowmload the .zip file
cd <your-project-folder-path>     // the path should lead to your file (e.g `C:\Users\Username\Desktop\TicketBooking-Server`)
```
2. Install PHP dependencies
```bash
composer install
```
3. Install Node dependencies and build assets
```bash
npm install
npm run dev     // this should run while the app is running 
```
4.  Configure the database
make sure that MySQL is installed and running you can you the start_server_win.ps1 to quickly format that data base to the required state or do it manually using th schema.sql

5.  Configure Environment
Copy .env.example to a new file.env
Set your database credentials (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
Configure mail with Mailtrap credentials for email testing:

Note if your using Mailtrape demo domain the email for the admin and the email of the booking user may need to be the same to resive an email on both sides 
because mailtrap only sends eamil to the email that was used during the creation of the account

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=no-reply@demomailtrap.co // if another domain is used this domain needs to be changed
MAIL_FROM_NAME="TicketBooking"
MAIL_ADMIN_ADDRESS=admin@example.com // this needs to be changed to the actual admin
```

Configure Stripe keys in .env (use Stripe test keys):

```bash
STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key
```

6. Run Migrations & Seed Database

```bash
php artisan migrate --seed
```
This will create the tables and seed an admin user.

7. Run the Application
```bash
php artisan serve
//or you can use the start_server_win.ps1 this will stat both servers and be much quicker for testing 
```
Access at http://localhost:8000

Admin Login
Use the seeded admin user:
```bash
Email: adminuser@text.com this can be changed in the .env file
Password: admin123 // this is the password 
```
Admin dashboard available at /admin

##Features

# Booking
- Users can book tickets by selecting ticket types and applying promo codes.
- Client-side and server-side validation implemented.
- Dynamic price updates based on selected promo codes.
- Confirmation emails sent to users and admins via Mailtrap.

# Admin Dashboard
- View all bookings.
- Filter bookings by ticket type.
- Export all bookings as CSV.
- See summary: total bookings and revenue.

# Payment
- Stripe sandbox integration for simulated payments (no real payment needed).

# Notes
- Mailtrap is used for email testing; real email sending is disabled.
- Stripe uses test mode keys; no real payment processing.
- Passwords are securely hashed.
- Promo codes and ticket prices are hardcoded (can be extended if needed).

# Promo Codes
- SAVE10
- EVENT20
