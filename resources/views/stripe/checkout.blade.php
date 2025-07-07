<!DOCTYPE html>
<html>
<head>
  <title>Stripe Checkout</title>
</head>
<body>
  <h1>Pay for your Ticket</h1>
  <form action="{{ route('stripe.session') }}" method="POST">
    @csrf
    <input type="hidden" name="amount" value="5000"> <!-- $50.00 -->
    <button type="submit">Pay with Stripe</button>
  </form>
</body>
</html>