<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Booking Form</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

  <div class="nav-bar">
    <button class="login-button" onclick="toggleAdminOverlay()">Admin Login</button>
  </div>


  <div class="container">
    <h2>Event Booking Form</h2>
    <form action="/stripe/session" method="POST" id="bookingForm">
      @csrf

      <div>
        <label>Ticket Type</label>
        <select id="ticketType" name="ticket_type">
          <option value="general">General Admission - $50</option>
          <option value="student">Student - $30</option>
          <option value="vip">VIP - $100</option>
          <option value="group">Group - $200</option>
        </select>
      </div>


      <div>
        <label>Full Name</label>
        <input type="text" name="name" required>
      </div>

      <div>
        <label>Email Address</label>
        <input type="email" name="email" required>
      </div>

      <div>
        <label>Mobile Number</label>
        <input type="tel" name="phone" required>
      </div>

      <div>
        <label>Country</label>
        <select name="country" required>
          <option value="">Select your country</option>
          <option value="germany">Germany</option>
          <option value="turkey">Turkey</option>
          <option value="usa">USA</option>
          <option value="uk">UK</option>
          <option value="canada">Canada</option>
          <option value="france">France</option>
        </select>
      </div>

      <div>
        <label>Organization / Job Title (optional)</label>
        <input id="organization" type="text" name="organization">
      </div>

      <div>
        <label>Promo Code</label>
        <input type="text" id="promoCode" name="promo_code" placeholder="Enter code">
      </div>

      <input type="hidden" id="finalPrice" name="final_price" value="50">

      <div class="total-price">
        Total Price: <span id="totalPrice">$50</span>
      </div>


      <button type="submit">Book Now</button>
    </form>
    <div id="formMessage"></div>
  </div>

  <div id="adminLoginOverlay" class="overlay hidden">
    <div class="overlay-content">
      <button class="closeButton" onclick="toggleAdminOverlay()" aria-label="Close">&times;</button>
      <h2>Admin Login</h2>
      <form id="adminLoginForm" method="POST" action="{{ route('admin.login') }}">
        @csrf
        <input type="email" name="email" placeholder="Admin Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <div id="adminLoginMessage"></div>
        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</body>
</html>