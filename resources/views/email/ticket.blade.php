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
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .ticket-header {
            background-color: #3498db;
            color: #fff;
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
            background-color: #3498db;
            color: #fff;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="ticket-header">
            <h2>Ticket</h2>
        </div>
        <div class="ticket-content">
            <p><strong>Ticket Number :</strong> {{ $mailData['ticketno'] }}</p>
            <p><strong>Station From :</strong> {{ $mailData['station_from'] }}</p>
            <p><strong>Station From :</strong> {{ $mailData['station_to'] }}</p>
            <p><strong>Depart Date :</strong> {{ $mailData['depart_date'] }}</p>
            <p><strong>Depart Time :</strong> {{ $mailData['depart_time'] }}</p>
            <p><strong>Arrive Time :</strong> {{ $mailData['arrive_time'] }}</p>
            <p><strong>Passenger :</strong> {{ $mailData['passenger'] }}</p>

            <span>Download full invoice </span><a href="{{ $mailData['link'] }}/print/ticket/{{ $mailData['bookingno'] }}" target="_blank">Here!</a>
        </div>
        <div class="ticket-footer">
            <p>Thank you for choosing Tigerline Ferry</p>
        </div>
    </div>
</body>
</html>
