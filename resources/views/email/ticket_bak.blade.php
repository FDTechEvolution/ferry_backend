<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Ticket</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }

        .ticket {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .ticket-header {
            background-color: #dfdfdf;
            color: #000000;
            padding: 20px;
        }

        .ticket-header h2 {
            margin: 0;
        }

        .ticket-content {
            padding: 20px;
        }

        .ticket-content p {
            margin: 0;
            line-height: 1.6;
            color: #333;
        }

        .ticket-footer {
            background-color: #dfdfdf;
            color: #000000;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="ticket-header">
            <h2>Your reservation has been confirmed.</h2>
        </div>
        <div class="ticket-content">
            <strong>Dear: {{$mailData['customer_name']}}</strong><br>
            <strong>Your Ticket Number: {{ $mailData['ticketno'] }}</strong><br><br>

            <p>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank you for choosing 168 Ferry.com! Your reservation has been confirmed.
Please find the details of your travel arrangements, as attached "itinerary.pdf".
When checking-in with the Tigerline Stations / Staff, please refer to Your Ticket Number. Also, have a valid photo ID ready for verification by our check-in staff.
If you would like to change your reservation, please call our call center at +6681 358 8989 (09:00-21:00) or Email 168ferry@gmail.com and refer to this number. Please note that change fees may apply.
            </p><br><br>

            <strong>Download your ticket </strong><a href="{{ $mailData['link'] }}/print/ticket/{{ $mailData['bookingno'] }}" target="_blank">Here!</a>
        </div>
        <div class="ticket-footer">
            <p>Kind regards,<br>
                Your Tigerline Ferry Team</p>
        </div>
    </div>
</body>
</html>
