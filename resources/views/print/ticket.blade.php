<!DOCTYPE html>
<html>

<head>
    <title>Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        .prow {
            width: 100%;
            position: relative;
            white-space: nowrap;

        }

        .w-50 {
            width: 50%;
        }
        .w-25{
            width: 25%;
        }
    </style>
</head>

<body>
    <div class="">
        <div class="prow">
            <table class="w-100">
                <tr>
                    <td class="w-50">
                        <img src="https://andamanexpress.com/assets/images/logo_tiger_line_ferry.png" alt=""
                            class="img-fluid w-100">
                    </td>
                    <td class="w-50 text-end">
                        <h1>Andamanexpress Ticket</h1>
                    </td>
                </tr>
            </table>

        </div>
        <hr>
        <div class="prow">
            <h2>YOUR BOOKING DETAILS</h2>
            <table class="w-100">
                <thead class="bg-secondary">
                    <tr>
                        <th class="w-15">DATE</th>
                        <th class="w-15">BOOKING NO</th>
                        <th class="w-15">TICKET NO</th>
                        <th class="w-15">DETAILS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td>{{$booking['bookingno']}}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</body>

</html>
