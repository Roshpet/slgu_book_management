<!DOCTYPE html>
<html>
<head>
    <style>
        /* Setup the watermark style */
        #watermark {
            position: fixed;
            top: 25%;
            left: 25%;
            width: 50%;
            height: auto;
            opacity: 0.1; /* Keeps it subtle so text is readable */
            z-index: -1000;
        }

        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; z-index: 1; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div id="watermark">
        <img src="{{ public_path('images/sogod_seal.jpg') }}" width="100%" height="100%">
    </div>

    <div class="header">
        <h2>REPUBLIC OF THE PHILIPPINES</h2>
        <h2>OFFICE OF THE MUNICIPAL CIVIL REGISTRAR</h2>
        <h3>Sogod, Southern Leyte</h3>
        <hr>
        <h4>MARRIAGE RECORDS REPORT</h4>
    </div>

    <table>
        <thead>
            <tr>
                <th>Reg. Date</th>
                <th>Reg. No.</th>
                <th>Husband's Name</th>
                <th>Wife's Name</th>
                <th>Marriage Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($marriages as $marriage)
            <tr>
                <td>{{ \Carbon\Carbon::parse($marriage->date_of_registration)->format('M d, Y') }}</td>
                <td>{{ $marriage->registration_number }}</td>
                <td>{{ strtoupper($marriage->husband_name) }}</td>
                <td>{{ strtoupper($marriage->wife_name) }}</td>
                <td>{{ \Carbon\Carbon::parse($marriage->date_of_marriage)->format('M d, Y') }}</td>
                <td>
                    @php
                        $days = \Carbon\Carbon::parse($marriage->date_of_registration)->diffInDays($marriage->date_of_marriage);
                    @endphp
                    {{ $days <= 30 ? 'On-time' : 'Delayed' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
