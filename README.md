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
4. Configure Environment
Copy .env.example to .env
Set your database credentials (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
Configure mail with Mailtrap credentials for email testing:

```bash
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="TicketBooking"
MAIL_ADMIN_ADDRESS=admin@example.com
```

Configure Stripe keys in .env (use Stripe test keys):

```bash
STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key
```

5. Run Migrations & Seed Database

```bash
php artisan migrate --seed
```
This will create the tables and seed an admin user.

6. Run the Application
```bash
php artisan serve
```
Access at http://localhost:8000

Admin Login
Use the seeded admin user:
```bash
Email: adminuser@text.com
Password: admin123
```
Admin dashboard available at /admin

Features
Booking
Users can book tickets selecting ticket type and applying promo codes.

Client-side and server-side validation.

Dynamic price updates with promo codes.

Confirmation emails sent to users and admins via Mailtrap.

Admin Dashboard
View all bookings.

Filter bookings by ticket type.

Export bookings as CSV.

See total bookings count and revenue summary.

Payment
Stripe sandbox integration for payment simulation.

Notes
Mailtrap is used for email testing; real email sending is disabled.

Stripe uses test mode keys; no real payment processing.

Passwords are hashed securely.

Promo codes and prices are hardcoded but can be extended.

Troubleshooting
If migrations fail, check your .env database settings.

If emails don't appear in Mailtrap, verify your Mailtrap credentials.

For frontend asset issues, run npm run dev again.

Clear cache if needed:

php artisan config:clear
php artisan cache:clear

License
MIT
