<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0.4in 0.5in; }
        body {
            font-family: 'Cambria', 'Georgia', serif;
            font-size: 16px;
            line-height: 1.3;
            color: #000;
        }
        #watermark {
            position: fixed; top: 22%; left: 10%; width: 80%; opacity: 0.12; z-index: -1000;
        }
        .lcr-form {
            position: absolute; top: -10px; left: 0; font-weight: bold; font-size: 14px;
        }

        /* HEADER TABLE LOGIC - Same as Death */
        .header-table { width: 100%; margin-top: 45px; margin-bottom: 35px; }
        .seal-cell { width: 15%; vertical-align: middle; }
        .header-text-cell {
            width: 85%;
            text-align: center;
            vertical-align: middle;
            padding-right: 15%;
        }
        .header-text-cell p { margin: 0; }
        .office-title { font-weight: bold; font-size: 17px; }

        .date-container { text-align: right; margin-bottom: 40px; font-weight: bold; }

        /* DATA ALIGNMENT */
        .info-table { width: 100%; border-collapse: collapse; margin-left: 5px; }
        .info-table td { padding: 1px 0; vertical-align: top; }
        .label { width: 220px; font-weight: bold; }
        .separator { width: 20px; text-align: center; }
        .value { text-transform: uppercase; }

        .footer-table { width: 100%; margin-top: 60px; text-align: center; }
        .sig-name { font-weight: bold; text-decoration: underline; text-transform: uppercase; }
        .sig-title { font-size: 13px; font-weight: bold; display: block; }

        .payment-section { margin-top: 65px; font-size: 14px; font-weight: bold; }
        .stamp-tax-text { text-align: center; line-height: 1.1; font-size: 13px; }
        .note-text { font-style: italic; font-size: 11px; margin-top: 45px; }
    </style>
</head>
<body>

    <div id="watermark">
        <img src="{{ public_path('images/sogod_seal.jpg') }}" style="width: 100%;">
    </div>

    <div class="lcr-form">LCR Form No. 1A<br>(Birth-available)</div>

    <table class="header-table">
        <tr>
            <td class="seal-cell">
                <img src="{{ public_path('images/sogod_seal.jpg') }}" style="width: 100px;">
            </td>
            <td class="header-text-cell">
                <p>Republic of the Philippines</p>
                <p class="office-title">OFFICE OF THE MUNICIPAL CIVIL REGISTRAR</p>
                <p>Sogod, Southern Leyte</p>
            </td>
        </tr>
    </table>

    <div class="date-container">{{ $details['current_date'] }}</div>

    <p><strong>TO WHOM IT MAY CONCERN:</strong></p>
    <p style="text-indent: 50px; text-align: justify;">
        We certify that among others, the following facts of birth appear in our Register of Birth on page {{ $birth->page_number }} of book number {{ $birth->book_number }}.
    </p>

    <table class="info-table">
        <tr><td class="label">MCR Registry Number</td><td class="separator">:</td><td class="value">{{ $birth->registration_number }}</td></tr>
        <tr><td class="label">Date of Registration</td><td class="separator">:</td><td class="value">{{ \Carbon\Carbon::parse($birth->date_of_registration)->format('F d, Y') }}</td></tr>
        <tr><td class="label">Name of Child</td><td class="separator">:</td><td class="value">{{ $birth->full_name }}</td></tr>
        <tr><td class="label">Sex</td><td class="separator">:</td><td class="value">{{ $birth->sex }}</td></tr>
        <tr><td class="label">Date of Birth</td><td class="separator">:</td><td class="value">{{ \Carbon\Carbon::parse($birth->date_of_birth)->format('F d, Y') }}</td></tr>
        <tr><td class="label">Place of Birth</td><td class="separator">:</td><td class="value">{{ $birth->place_of_birth }}</td></tr>
        <tr><td class="label">Name of Mother</td><td class="separator">:</td><td class="value">{{ $birth->name_of_mother }}</td></tr>
        <tr><td class="label">Nationality</td><td class="separator">:</td><td class="value">{{ $birth->mother_nationality }}</td></tr>
        <tr><td class="label">Name of Father</td><td class="separator">:</td><td class="value">{{ $birth->name_of_father }}</td></tr>
        <tr><td class="label">Nationality</td><td class="separator">:</td><td class="value">{{ $birth->father_nationality }}</td></tr>
        <tr><td class="label">Date of Marriage of Parents</td><td class="separator">:</td><td class="value">{{ $birth->date_of_marriage ? \Carbon\Carbon::parse($birth->date_of_marriage)->format('F d, Y') : 'NOT APPLICABLE' }}</td></tr>
        <tr><td class="label">Place of Marriage of Parents</td><td class="separator">:</td><td class="value">{{ $birth->place_of_marriage ?? 'NOT APPLICABLE' }}</td></tr>
    </table>

    <p style="margin-top: 30px;">This certification is issued to <strong>{{ strtoupper($details['issued_to']) }}</strong> upon {{ $details['gender_ref'] }} request.</p>

    <p>Verify by:</p>

    <table class="footer-table">
        <tr>
            <td width="50%"><span class="sig-name">NORMA S. TORION</span><br><span class="sig-title">CLERK III</span></td>
            <td width="50%"><span class="sig-name">CEASAR LEOPOLDO A. REGIS</span><br><span class="sig-title">MUNICIPAL CIVIL REGISTRAR</span></td>
        </tr>
    </table>

    <div class="payment-section">
        <table width="100%">
            <tr>
                <td width="48%">
                    <div>Amount Paid : {{ $details['amount_paid'] }}</div>
                    <div>O.R. Number : {{ $details['or_number'] }}</div>
                    <div>Date Paid : {{ $details['date_paid'] }}</div>
                </td>
                <td width="52%" class="stamp-tax-text">
                    "DOCUMENTARY STAMP TAX PAID"<br>
                    <div style="font-size: 15px; margin-top: 5px;">{{ $details['or_number'] }} &nbsp;&nbsp;&nbsp; {{ $details['date_paid'] }}</div>
                    <div style="font-size: 11px;">(GOR SERIAL NUMBER) &nbsp;&nbsp; (DATE OF PAYMENT)</div>
                </td>
            </tr>
        </table>
    </div>

    <p class="note-text">Note: This certification is not valid if it has mark of erasure or alternation of any entry.</p>

</body>
</html>
