<!DOCTYPE html>
<html>
<head>
    <title>Death Records Report</title>
    <style>
        @page {
            margin: 0.5in;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        /* Header Styling */
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h3 {
            margin: 0;
            text-transform: uppercase;
            font-size: 18px;
        }
        .header p {
            margin: 2px 0;
            font-size: 14px;
        }
        .report-title {
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            margin-top: 20px;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-top: 2px solid #000;
            padding-top: 10px;
        }
        /* Watermark */
        #watermark {
            position: fixed;
            top: 25%;
            left: 25%;
            width: 50%;
            height: auto;
            opacity: 0.1; /* Keeps it subtle so text is readable */
            z-index: -1000;
        }
        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 10px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
            border: 1px solid #ccc;
            padding: 8px;
        }
        td {
            border: 1px solid #ccc;
            padding: 8px;
            vertical-align: middle;
        }
        .text-center {
            text-align: center;
        }
        .fw-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div id="watermark">
        <img src="{{ public_path('images/sogod_seal.jpg') }}" style="width: 100%;">
    </div>

    <div class="header">
        <h3>Republic of the Philippines</h3>
        <p class="fw-bold">OFFICE OF THE MUNICIPAL CIVIL REGISTRAR</p>
        <p>Sogod, Southern Leyte</p>
    </div>

    <div class="report-title">
        DEATH RECORDS REPORT
    </div>

    <table>
        <thead>
            <tr>
                <th width="12%">Reg. Date</th>
                <th width="10%">Reg. No.</th>
                <th width="20%">Full Name</th>
                <th width="8%">Sex</th>
                <th width="10%">Nationality</th>
                <th width="5%">Age</th>
                <th width="12%">Date of Death</th>
                <th>Cause of Death</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deaths as $death)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($death->date_of_registration)->format('M d, Y') }}</td>
                    <td class="fw-bold">{{ $death->registration_number }}</td>
                    <td>{{ strtoupper($death->full_name) }}</td>
                    <td>{{ $death->sex }}</td>
                    <td>{{ $death->nationality }}</td>
                    <td class="text-center">{{ $death->age }}</td>
                    <td>{{ \Carbon\Carbon::parse($death->date_of_death)->format('M d, Y') }}</td>
                    <td>{{ strtoupper($death->cause_of_death) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
