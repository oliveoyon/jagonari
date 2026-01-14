<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Admit Card</title>
    <style>
        body {
            font-family: solaimanlipi, sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .details {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }

        .details td,
        .details th {
            border: 1px solid #000;
            padding: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
        }

        h2,
        h4 {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Organization Name</h2>
        <h4>Admit Card</h4>
    </div>

    <table class="details" width="100%" border="1" cellspacing="0" cellpadding="5">
        <tr>
            <td>Candidate Name</td>
            <td>{{ $application->name }}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{ $application->email ?? '-' }}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{ $application->phone ?? '-' }}</td>
        </tr>
        <tr>
            <td>Circular</td>
            <td>{{ $application->circular->title }}</td>
        </tr>
        <tr>
            <td>Circular Date</td>
            <td>{{ $application->circular->published_date }}</td>
        </tr>
        <tr>
            <td>Admit Card No</td>
            <td>{{ 'ADM-' . $application->id }}</td>
        </tr>
    </table>

    <div class="footer">
        This card is valid only for the candidate's examination.
    </div>
</body>

</html>
