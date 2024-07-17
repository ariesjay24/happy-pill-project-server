<!DOCTYPE html>
<html>
<head>
    <title>Booking Confirmation</title>
</head>
<body>
    <h1>Booking Confirmation</h1>
    <p>Dear {{ $details['userName'] }},</p>
    <p>Thank you for booking with us! Here are your booking details:</p>
    <ul>
        <li>Service: {{ $details['serviceType'] }}</li>
        <li>Date: {{ $details['bookingDate'] }}</li>
        <li>Time: {{ $details['bookingTime'] }}</li>
        <li>Location: {{ $details['location'] }}</li>
        <li>Add-Ons: {{ implode(', ', $details['addOns']) }}</li>
        <li>Total Price: ₱{{ number_format($details['totalPrice'], 2) }}</li>
    </ul>
    <p>We look forward to serving you!</p>
</body>
</html>
