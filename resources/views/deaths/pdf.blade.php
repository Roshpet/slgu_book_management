<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Death Records Report</title>
    <style>
        /* PDF Page Setup - Legal standard, Landscape */
        @page {
            margin: 0.5in;
            size: legal landscape;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #000;
            position: relative;
        }

        /* FIXED BACKGROUND WATERMARK - Perfectly Centered */
        #watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 450px;
            opacity: 0.1;
            z-index: -1000;
        }

        /* Header Styling */
        .header-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-section p { margin: 2px 0; }
        .office-title { font-weight: bold; font-size: 15px; text-transform: uppercase; }

        /* Report Title */
        .report-title-container {
            text-align: center;
            margin-bottom: 20px;
            border-top: 2px solid #000;
            padding-top: 10px;
        }
        .report-title-container p {
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 13px;
        }

        /* Table Styling */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            text-align: left;
            padding: 6px;
            border: 1px solid #ddd;
        }

        .data-table td {
            padding: 6px;
            border: 1px solid #ddd;
            text-transform: uppercase;
            vertical-align: middle;
        }

        /* Specific width for row number */
        .col-no {
            width: 25px;
            text-align: center;
            font-weight: bold;
        }

        .data-table tr:nth-child(even) { background-color: #f9f9f9; }

        .fw-bold { font-weight: bold; }
        .text-center { text-align: center; }

        .footer-note {
            margin-top: 20px;
            font-size: 10px;
            text-align: center;
            color: #555;
        }
    </style>
</head>
<body>

    <div id="watermark">
        <img src="{{ public_path('images/sogod_seal.jpg') }}" style="width: 100%;">
    </div>

    <div class="header-section">
        <p>REPUBLIC OF THE PHILIPPINES</p>
        <p class="office-title">OFFICE OF THE MUNICIPAL CIVIL REGISTRAR</p>
        <p>Sogod, Southern Leyte</p>
    </div>

    <div class="report-title-container">
        <p>DEATH RECORDS REPORT</p>
        @if(request('search'))
            <p style="font-size: 11px; font-weight: normal; text-transform: none; color: #555;">Filtered by: "{{ request('search') }}"</p>
        @endif
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="col-no">#</th>
                <th style="width: 85px;">Reg. Date</th>
                <th style="width: 80px;">Reg. No.</th>
                <th>Full Name</th>
                <th style="width: 50px;">Sex</th>
                <th style="width: 80px;">Nationality</th>
                <th style="width: 40px;">Age</th>
                <th style="width: 85px;">Date of Death</th>
                <th>Cause of Death</th>
            </tr>
        </thead>
        <tbody>
            @forelse($deaths as $death)
                <tr>
                    <td class="col-no">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($death->date_of_registration)->format('M d, Y') }}</td>
                    <td class="fw-bold">{{ $death->registration_number }}</td>
                    <td>{{ strtoupper($death->full_name) }}</td>
                    <td>{{ $death->sex }}</td>
                    <td>{{ $death->nationality }}</td>
                    <td class="text-center">{{ $death->age }}</td>
                    <td>{{ \Carbon\Carbon::parse($death->date_of_death)->format('M d, Y') }}</td>
                    <td>{{ strtoupper($death->cause_of_death) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 20px; color: #777;">No records found matching your search.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer-note">Generated on {{ now()->format('F d, Y @ h:i A') }}</p>

</body>
</html>
