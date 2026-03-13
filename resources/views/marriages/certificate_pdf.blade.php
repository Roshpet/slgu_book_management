<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        /* PDF Page Setup - Folio/Legal standard */
        @page { margin: 0.5in; }
        body { font-family: 'DejaVu Sans', 'Arial', sans-serif; font-size: 13px; line-height: 1.4; color: #000; }

        /* Background Watermark - Kept at 25% */
        #watermark {
            position: fixed;
            top: 25%;
            left: 15%;
            width: 70%;
            opacity: 0.12;
            z-index: -1000;
        }

        /* Metadata for LCR Form 3A */
        .lcr-form { position: absolute; top: 0; left: 0; font-weight: bold; font-size: 11px; }

        /* Lowered Header Block */
        .header-table {
            width: 100%;
            border: none;
            margin-top: 60px;
            margin-bottom: 30px;
        }

        .seal-cell { width: 15%; vertical-align: middle; }
        .header-text-cell {
            width: 85%;
            text-align: center;
            vertical-align: middle;
            padding-right: 15%;
        }

        .date-container { text-align: right; margin-bottom: 25px; font-weight: bold; }

        .main-content { margin-top: 10px; }
        .cert-text { margin-bottom: 20px; text-indent: 50px; text-align: justify; }

        /* Alignment for Husband/Wife data */
        .info-table { width: 100%; margin-left: 10px; border: none; }
        .info-table td { padding: 1px 0; vertical-align: top; }

        .label { width: 185px; font-weight: bold; }
        .separator { width: 15px; text-align: center; }
        .value { width: 200px; text-transform: uppercase; font-weight: normal; }

        /* Signature Section */
        .footer-table { width: 100%; margin-top: 50px; text-align: center; }
        .sig-name { font-weight: bold; text-decoration: underline; text-transform: uppercase; }
        .sig-title { font-size: 11px; font-weight: bold; display: block; }

        /* Payment Section */
        .payment-section { margin-top: 40px; font-size: 12px; font-weight: bold; }
        .stamp-tax-text {
            text-align: right;
            line-height: 1.2;
            font-size: 11px;
            margin-right: 19px;
        }
    </style>
</head>
<body>

    <div id="watermark">
        <img src="{{ public_path('images/sogod_seal.jpg') }}" style="width: 100%;">
    </div>

    <div class="lcr-form">LCR Form No. 3A<br>(Marriage-available)</div>

    <table class="header-table">
        <tr>
            <td class="seal-cell">
                <img src="{{ public_path('images/sogod_seal.jpg') }}" style="width: 95px;">
            </td>
            <td class="header-text-cell">
                Republic of the Philippines<br>
                <strong>OFFICE OF THE MUNICIPAL CIVIL REGISTRAR</strong><br>
                Sogod, Southern Leyte
            </td>
        </tr>
    </table>

    <div class="date-container">
        {{ $details['current_date'] }}
    </div>

    <div class="main-content">
        <p><strong>TO WHOM IT MAY CONCERN:</strong></p>

        <p class="cert-text">
            We certify that among others, the following facts of marriage appear in our Register of Marriage on page {{ $marriage->page_number }} of book number {{ $marriage->book_number }}.
        </p>

        <table class="info-table">
            <tr>
                <td class="label">Name</td><td class="separator">:</td><td class="value">{{ $marriage->husband_name }}</td>
                <td class="separator">:</td><td class="value">{{ $marriage->wife_name }}</td>
            </tr>
            <tr>
                <td class="label">Age</td><td class="separator">:</td><td class="value">{{ $marriage->age_husband }}</td>
                <td class="separator">:</td><td class="value">{{ $marriage->age_wife }}</td>
            </tr>
            <tr>
                <td class="label">Nationality</td><td class="separator">:</td><td class="value">{{ $marriage->father_nationality_husband }}</td>
                <td class="separator">:</td><td class="value">{{ $marriage->father_nationality_wife }}</td>
            </tr>
            <tr>
                <td class="label">Mother</td><td class="separator">:</td><td class="value">{{ $marriage->mother_husband }}</td>
                <td class="separator">:</td><td class="value">{{ $marriage->mother_wife }}</td>
            </tr>
            <tr>
                <td class="label">Nationality</td><td class="separator">:</td><td class="value">{{ $marriage->mother_nationality_husband }}</td>
                <td class="separator">:</td><td class="value">{{ $marriage->mother_nationality_wife }}</td>
            </tr>
            <tr>
                <td class="label">Father</td><td class="separator">:</td><td class="value">{{ $marriage->father_husband }}</td>
                <td class="separator">:</td><td class="value">{{ $marriage->father_wife }}</td>
            </tr>
            <tr>
                <td class="label">Nationality</td><td class="separator">:</td><td class="value">{{ $marriage->father_nationality_husband }}</td>
                <td class="separator">:</td><td class="value">{{ $marriage->father_nationality_wife }}</td>
            </tr>
        </table>

        <table class="info-table" style="margin-top: 15px;">
            <tr>
                <td class="label">Local Registry Number</td><td class="separator">:</td><td class="value" colspan="3">{{ $marriage->registration_number }}</td>
            </tr>
            <tr>
                <td class="label">Date of Registration</td><td class="separator">:</td><td class="value" colspan="3">{{ \Carbon\Carbon::parse($marriage->date_of_registration)->format('F d, Y') }}</td>
            </tr>
            <tr>
                <td class="label">Date of Marriage</td><td class="separator">:</td><td class="value" colspan="3">{{ \Carbon\Carbon::parse($marriage->date_of_marriage)->format('F d, Y') }}</td>
            </tr>
            <tr>
                <td class="label">Place of Marriage</td><td class="separator">:</td><td class="value" colspan="3">{{ strtoupper($marriage->place_of_marriage) }}</td>
            </tr>
        </table>

        <p style="margin-top: 35px;">
            This certification is issued to <span style="font-weight: bold;">{{ strtoupper($details['issued_to']) }}</span> upon {{ $details['gender_ref'] }} request.
        </p>

        <p>Verify by:</p>

        <table class="footer-table">
            <tr>
                <td>
                    <span class="sig-name">NORMA S. TORION</span>
                    <span class="sig-title">CLERK III</span>
                </td>
                <td>
                    <span class="sig-name">CEASAR LEOPOLDO A. REGIS</span>
                    <span class="sig-title">MUNICIPAL CIVIL REGISTRAR</span>
                </td>
            </tr>
        </table>

        <div class="payment-section">
            <table width="100%">
                <tr>
                    <td width="45%">
                        <div class="or-item">Amount Paid : {{ $details['amount_paid'] }}</div>
                        <div class="or-item">O.R. Number : {{ $details['or_number'] }}</div>
                        <div class="or-item">Date Paid : {{ $details['date_paid'] }}</div>
                    </td>
                    <td width="55%" class="stamp-tax-text">
                        "DOCUMENTARY STAMP TAX PAID"<br>
                        {{ $details['or_number'] }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ $details['date_paid'] }}<br>
                        (GOR SERIAL NUMBER) &nbsp;&nbsp; (DATE OF PAYMENT)
                    </td>
                </tr>
            </table>
        </div>

        <p style="font-style: italic; font-size: 10px; margin-top: 30px;">
            Note: This certification is not valid if it has mark of erasure or alternation of any entry.
        </p>
    </div>

</body>
</html>
