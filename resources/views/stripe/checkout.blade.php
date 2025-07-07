<!DOCTYPE html>
<html>
<head>
  <title>Stripe Checkout</title>
  @vite(['resources/css/checkout.css'])
</head>
<body>
  <form action="{{ route('stripe.session') }}" method="POST">
    @csrf
    <input type="hidden" name="amount" value="5000"> <!-- $50.00 -->
    <button type="submit" class="Stripe">Pay with Stripe</button>
  </form>
    <button type="submit" class="PayPal">Pay with PayPal test</button>
    <button type="submit" class="BankCard">Pay with BankCard test</button>
</body>
</html>