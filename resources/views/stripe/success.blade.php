<!DOCTYPE html>
<html>
<head>
    <title>Payment Success</title>
</head>
<body style="text-align:center; font-family: sans-serif;">

    <h1>{{ $message }}</h1>
    
    <p>Scan this QR code for your Booking details:</p>
    <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">

    <br><br>
    <a href="/">Return Home</a>

</body>
</html>