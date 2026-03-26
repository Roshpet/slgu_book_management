<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Birth Records Report</title>
    <style>
        /* PDF Page Setup - Legal standard, Landscape */
        @page {
            margin: 0.5in;
            size: legal landscape;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 11px; /* Slightly smaller for better fit with row numbers */
            line-height: 1.3;
            color: #000;
            position: relative;
        }

        /* FIXED BACKGROUND WATERMARK - Perfectly Centered */
        #watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); /* Ensures it centers regardless of image size */
            width: 450px;
            opacity: 0.1;
            z-index: -1000;
        }

        .header-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-section p { margin: 2px 0; }
        .office-title { font-weight: bold; font-size: 15px; }

        .report-title-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .report-title-container p {
            margin: 0;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 13px;
        }

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
        }

        /* Specific width for row number */
        .col-no {
            width: 25px;
            text-align: center;
            font-weight: bold;
        }

        .data-table tr:nth-child(even) { background-color: #f9f9f9; }

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
        <p>BIRTH RECORDS REPORT</p>
        @if(request('search'))
            <p style="font-size: 11px; font-weight: normal; text-transform: none; color: #555;">Filtered by: "{{ request('search') }}"</p>
        @endif
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="col-no">#</th>
                <th style="width: 80px;">Reg. Date</th>
                <th style="width: 80px;">Reg. No.</th>
                <th>Child's Full Name</th>
                <th style="width: 60px;">Sex</th>
                <th style="width: 80px;">Nationality</th>
                <th style="width: 80px;">Date of Birth</th>
                <th>Place of Birth</th>
            </tr>
        </thead>
        <tbody>
            @forelse($births as $birth)
                <tr>
                    <td class="col-no">{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($birth->date_of_registration)->format('M d, Y') }}</td>
                    <td style="font-weight: bold;">{{ $birth->registration_number }}</td>
                    <td>{{ $birth->full_name }}</td>
                    <td>{{ $birth->sex }}</td>
                    <td>{{ $birth->nationality }}</td>
                    <td>{{ \Carbon\Carbon::parse($birth->date_of_birth)->format('M d, Y') }}</td>
                    <td>{{ $birth->place_of_birth }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #777; padding: 20px;">No records found matching your search.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer-note">Generated on {{ now()->format('F d, Y @ h:i A') }}</p>

</body>
</html>
