<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Identity Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 6px; /* Adjusted font size for A6 landscape */
            color: #000;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            /* min-height: 100vh; */
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
                size: A6 landscape;
                margin: 2mm; /* Smaller margin for A6 */
            }

            body {
                background: none;
            }

            .container {
                page-break-before: always; /* Forces a page break before each student */
            }
        }

        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .header-table,
        .subject-table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 5px; Reduced margin */
        }

        .header-table tr {
            vertical-align: middle;
            text-align: center;
        }

        .student-details tr {
            vertical-align: middle;
            text-align: left;
        }

        .header-logo img {
            width: 40px; /* Adjusted logo size for A6 */
            height: auto;
        }

        .subject-table th,
        .subject-table td {
            /* padding: 3px; Reduced padding for A6 */
            border: 1px solid #ddd;
            text-align: center;
            font-size: 6px; /* Font size for table */
        }

        .subject-table th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
            font-size: 14px; /* Adjusted font size */
            margin: 0;
        }

        h3 {
            text-align: center;
            font-size: 10px; /* Adjusted sub-header size */
            margin: 5px 0;
        }

        .page-break {
            page-break-before: always;
        }

        .footer {
            text-align: center;
            border-top: 1px solid #000;
            position: absolute;
            width: 100%;
            bottom: 0;
        }

        .student-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0; /* Space below the student info */
        }

        .student-details {
            flex: 1; /* Take remaining space */
            margin-right: 5px; /* Space between text and image */
        }

        .student-image {
            text-align: center; /* Center the image and text below it */
            width: 40%; /* Adjust width for image container */
        }

        .student-image img {
            max-width: 80px; /* Set a maximum width for the image */
            height: auto;
        }
    </style>
</head>

<body>

    @foreach ($students as $student)
        <div class="container">
            <!-- Centered Header -->
            <table class="header-table" style="font-weight: bold; font-size:7px">
                <tr>
                    <td>
                        <img src="{{ $camLogo }}" style="height: 30px" alt="SCHOOL LOGO">
                        <p>
                            RÉPUBLIQUE DU CAMEROUN <br>
                            Paix – Travail – Patrie <br>
                        </p>
                    </td>
                    <td class="header-logo">
                        <p>
                            MINISTÈRE DES ENSEIGNEMENTS SECONDAIRES <br>
                            DÉLÉGATION RÉGIONALE DU CENTRE <br>
                            DÉLÉGATION DÉPARTEMENTALE DU MBAM ET INOUBOU <br>
                        </p>
                    </td>
                    <td>
                        <img src="{{ $camLogo }}" style="height: 30px" alt="SCHOOL LOGO">
                        <p>
                            REPUBLIC OF CAMEROUN <br>
                            Peace – Work – Fatherland <br>
                        </p>
                    </td>
                </tr>
            </table>

            <!-- Report Title -->
            <h2>
                COLLEGE BILINGUE "LES PAPANETTES" <br>
                <small style="font-style: italic"><small>BILINGUAL COLLEGE "LES PAPANETTES"</small></small>
            </h2>
            <h3 style="margin-bottom: 5px; margin-top: 0">
                Discipline – Travail - Succes <br>
            </h3>
            <h3 style="font-size: 13px">
                CARTE D'IDENTITE SCOLAIRE <br>
                <small style="font-style: italic">SCHOOL IDENTITY CARD</small>
            </h3>

            <div>
                <table class="students-details" style="width: 100%; justify-content: space-between; align-items: center; margin:0">
                    <tr style="width: 100%; display: contents;">
                        <td style="flex: 1; padding-left:30px; font-size:10px; font-weight:bold">
                            <p>NOM DE L'ELEVÉ: &nbsp;<u>{{ strtoupper($student->first_name) }} {{ strtoupper($student->last_name) }}</u></p>
                            <p>NEE LE: &nbsp;<u>{{ \Carbon\Carbon::parse($student->date_of_birth)->format('d/m/Y') }}</u> &nbsp; À: &nbsp;<u>{{ strtoupper($student->place_of_birth) }}</u></p>
                            <p>SEXE: &nbsp;<u>{{ strtoupper($student->sex) }}</u> &nbsp; CLASSE: &nbsp;<u>{{ $student->classe->name }}</u></p>
                            <p>ADMISSION N0: &nbsp;<u>{{ $student->matricule }}</u></p>
                            <p>ANNEE SCOLAIRE: &nbsp;<u>2024 - 2025</u></p> <br><br>
                        </td>


                        <td class="student-image" style="text-align: center; width: 30%;">
                            <img src="{{ $student->imageUrl }}" alt="Student Picture" style="max-width: 80px;"><br><br>
                            <p style="font-size: 10px; font-weight:bold">THE PRINCIPAL</p>
                            <p style="font-size: 10px; font-weight:bold">_______________________________</p>
                        </td>

                    </tr>
                </table>
            </div>

            <!-- Footer -->
            {{-- <footer class="footer" style="font-weight: bold">
                <p>IF LOST BUT FOUND, CONTACT SCHOOL ADMINISTRATION | Phone: 673 156 416 / 687 694 598 / 695 382 661</p>
            </footer> --}}
        </div>

        <div class="page-break"></div>
    @endforeach

</body>

</html>
