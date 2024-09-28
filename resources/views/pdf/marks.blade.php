
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Sheet</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px; /* Default font size */
            color: #000;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Make sure body takes up full height */
        }

        body::before {
            content: '';
            position: fixed;
            top: 50%;
            left: 50%;
            width: 70%;
            height: 70%;
            background-image: url('assets/images/logo.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.1;
            transform: translate(-50%, -50%);
            z-index: -1;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(255, 255, 255, 0.5);
            z-index: -1;
        }

        @media print {
            @page {
                size: auto;
                margin: 5ch;
            }

            body {
                background: none;
            }
        }

        .container {
            flex: 1; /* Allow container to grow and fill space */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* Push footer to the bottom */
        }

        .header-table,
        .subject-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .header-table tr {
            vertical-align: middle;
            text-align: center;
            /* padding: 10px; */
        }



        .header-logo img {
            width: 80px;
            height: auto;
        }

        .classe-table th {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 12px; /* Increased font size */
            width: 100%;
        }

        .classe-table th {
            background-color: #e9ecef; /* Light grey for header */
        }

        .subject-table th {
            padding-top: 7px;
            padding-bottom: 7px;
            border: 1px solid black;
            text-align: center;
            font-size: 11px; /* Increased font size for table */
        }

        .subject-table td {
            padding: 7px;
            border: 1px solid black;
            text-align: left;
            font-size: 11px; /* Increased font size for table */
        }

        .subject-table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        h2 {
            text-align: center;
            font-size: 25px; /* Larger font for school name */
            margin: 0;
        }

        h3 {
            text-align: center;
            font-size: 15px; /* Smaller font for additional info */
            margin: 5px 0;
        }

        .footer {
            text-align: center;
            border-top: 1px solid #000; /* Optional border */
            bottom: 0;
            position: absolute;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- Centered Header -->
        <table class="header-table">
            <tr>
                <td>
                    <p>
                        RÉPUBLIQUE DU CAMEROUN <br>
                        Paix – Travail – Patrie <br>
                        MINISTÈRE DES ENSEIGNEMENTS SECONDAIRES <br>
                        DÉLÉGATION RÉGIONALE DE … <br>
                        DÉLÉGATION DÉPARTEMENTALE DE … <br>
                        <strong>COLLEGE BILINGUE "LES PAPANETTES"</strong> <br>
                    </p>
                </td>
                <td class="header-logo">
                    <img src="{{ $logoPath }}" alt="SCHOOL LOGO">
                </td>
                <td>
                    <p>
                        REPUBLIC OF CAMEROUN <br>
                        Peace – Work – Fatherland <br>
                        MINISTRY OF SECONDARY EDUCATION <br>
                        REGIONAL DELEGATION OF … <br>
                        DIVISIONAL DELEGATION … <br>
                        <strong>BILINGUAL COLLEGE "LES PAPANETTES"</strong> <br>
                    </p>
                </td>
            </tr>
        </table>

        <!-- Report Title -->
        <h2>
            COLLEGE BILINGUE "LES PAPANETTES" <br>
            <small style="font-style: italic"><small>BILINGUAL COLLEGE "LES PAPANETTES"</small></small>
        </h2>
        <h3 style="margin: 0">
            Année scolaire: 2023/2024 <br>
            MOTTO: Discipline – Hardwork - Success <br>
            {{-- Tel: 673 156 416 / 687 694 598 / 695 382 661 --}}
        </h3>

        <h2 style="text-align: center; margin: 20px; font-size: 18px">
            MARK SHEET {{ $classe->name }}
        </h2>

        <div>
            <table class="classe-table" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 33%;">SUBJECT: {{ $subject ? $subject->name : '' }}</th>
                        <th style="width: 33%;">TEACHER: {{ $subject ? $subject->teacher : '' }}</th>
                        <th style="width: 34%;">EVALUATION NO: {{ $sequence }}</th>
                    </tr>
                </thead>
            </table>
        </div>

        <p></p>

        <!-- Marks Table -->
        <div class="info-section">
            <table class="subject-table">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Matricule</th>
                        <th>Student Name</th>
                        <th>Mark</th>
                        <th>Appreciation</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($marks as $key => $mark)
                        <tr>
                            <td style="text-align: center">{{ $key + 1 }}</td>
                            <td>{{ strtoupper($mark->student->matricule) }}</td>
                            <td>{{ strtoupper($mark->student->first_name) }} {{ strtoupper($mark->student->last_name) }}</td>
                            <td style="text-align: center">{{ $mark->mark }}</td>
                            <td style="text-align: center">{{ $mark->appreciation }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-info">
                                <h5 class="mb-0">No marks found for this class and subject</h5>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <p>BILINGUAL COLLEGE "LES PAPANETTES" | Address: [School Address] | Phone: 673 156 416 / 687 694 598 / 695 382 661</p>
        </footer>

    </div>
</body>

</html>

