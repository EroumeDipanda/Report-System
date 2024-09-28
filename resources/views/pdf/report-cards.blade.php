<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Card</title>
    <style>
        /* Styles for the document */
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            position: relative;
            overflow: hidden;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* Pseudo-element for the background image */
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

        /* White overlay to further dim the image */
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

        /* Page break handling for printing */
        @media print {
            @page {
                size: auto;
                margin: 5ch;
                background: url('assets/images/logo.jpg') no-repeat center center;
                background-size: 70%;
            }

            body {
                background: none;
            }
        }

        .header-table {
            width: 100%;
            margin-bottom: 10px;
            border-collapse: collapse;
            text-align: center;
        }

        .header-table td {
            vertical-align: middle;
        }

        .header-logo img {
            width: 80px;
            height: auto;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            /* margin-bottom: 5px; */
            border: 1px solid black;
        }

        .info-table th,
        .info-table td {
            padding: 6px;
            text-align: left;
            border: 1px solid black;
        }

        .subject-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3px;
            font-size: 9px;
            border: 1px solid black;
        }

        .subject-table th,
        .subject-table td {
            border: 1px solid black;
            padding: 3px;
        }

        .section-title {
            margin-top: 10px;
            font-weight: bold;
            font-size: 13px;
            text-align: left;
        }

        .footer {
            text-align: center;
            margin-top: 15px;
        }

        .page-break {
            page-break-before: always;
        }

        .info-section,
        .subject-table {
            font-size: 9px;
        }
    </style>
</head>

<body>
    <div class="container">
        @foreach ($studentsData as $studentId => $studentData)
            @php
                $student = $studentData['info'];
                $marksData = $studentData['marksData'];
                $totalWeightedMarks = $studentData['totalWeightedMarks'];
                $totalCoef = $studentData['totalCoef'];
                $average = $totalCoef ? $totalWeightedMarks / $totalCoef : 0;
            @endphp

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
                        <img src="{{ $leftLogoPath }}" alt="SCHOOL LOGO">
                    </td>
                    <td>
                        <p>
                            REPUBLIC OF CAMEROON <br>
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
            <h2 style="text-align: center;">
                BULLETIN SCOLAIRE DU {{ $term == 1 ? 'PREMIER' : ($term == 2 ? 'DEUXIÈME' : 'TROISIÈME') }} TRIMESTRE
                <br>
                Année scolaire: 2023/2024
            </h2>

            <!-- Student Information Table -->
            <div class="info-section" style="font-size: 11px;">
                <table class="info-table" style="font-size: 11px;">
                    <tr>
                        <td rowspan="3" style="text-align: center; vertical-align: middle; padding:1px ; margin:0">
                            @if ($student->photo)
                                <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo"
                                    style="height: 100px; width: 100px; object-fit: cover;">
                            @else
                            <img src="{{ $profile }}" alt="Default Photo"
                            style="height: 80px; width: 80px; object-fit: contain;">

                            @endif
                        </td>
                        <td colspan="2"><strong>STUDENT NAME: </strong>&nbsp;{{ strtoupper($student->first_name) }} {{ strtoupper($student->last_name) }}</td>
                        <td><strong>CLASSE: </strong>&nbsp;&nbsp;{{ $classe->name }}</td>
                        <td><strong>ENROLLMENT: </strong>&nbsp; {{ $classe->students->count() }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>DATE OF BIRTH:</strong>&nbsp;{{ $student->date_of_birth }}</td>
                        <td><strong>PLACE OF BIRTH:</strong>&nbsp; {{ strtoupper($student->place_of_birth) }}</td>
                        <td><strong>GENDER:  &nbsp;</strong>&nbsp;{{ $student->sex == 'male' ? 'M' : 'F' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>MATRICULE:  &nbsp;</strong>&nbsp;{{ strtoupper($student->matricule) }}</td>
                        <td colspan="2"><strong>PROFESSEUR PRINCIPAL:&nbsp;</strong>&nbsp;{{ $classe->classe_master ? strtoupper($classe->classe_master) : 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            &nbsp;
            <!-- Marks Table -->
            <div class="info-section" style="font-size: 11px; margin-bottom: 5px">
                <table class="subject-table" style="font-size: 11px">
                    <thead>
                        <tr>
                            <th>MATIÈRES ET NOM DE L’ENSEIGNANT</th>
                            <th colspan="2" style="width: 50px">N /20</th>
                            <th style="width: 50px">M /20</th>
                            <th style="width: 50px">Coef</th>
                            <th style="width: 50px">M*coef</th>
                            <th style="width: 50px">COTE</th>
                            <th>Appreciation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $subject)
                            @php
                                $marks = $marksData[$subject->id] ?? [
                                    'eval1' => 0,
                                    'eval2' => 0,
                                    'average' => 0,
                                    'weightedMark' => 0,
                                    'grade' => '',
                                    'appreciation' => ''
                                ];
                                $weightedMark = $marks['average'] * $subject->coef;
                            @endphp
                            <tr>
                                <td>{{ $subject->name }}
                                    <br><small>{{ $subject->teacher ?? '' }}</small>
                                </td>
                                <td style="text-align: center;">{{ $marks['eval1'] }}</td>
                                <td style="text-align: center;">{{ $marks['eval2'] }}</td>
                                <td style="text-align: center;">{{ $marks['average'] }}</td>
                                <td style="text-align: center;">{{ $subject->coef }}</td>
                                <td style="text-align: center;">{{ number_format($weightedMark, 2) }}</td>
                                <td style="text-align: center;">{{ $marks['grade'] }}</td>
                                <td>{{ $marks['appreciation'] }}</td>
                            </tr>
                        @endforeach
                        <!-- Total Row -->
                        <tr>
                            <td colspan="3" style="text-align: center;"><strong>TOTAL:</strong></td>
                            <td style="text-align: center;"><strong></strong></td>
                            <td style="text-align: center;"><strong>{{ $totalCoef }}</strong></td>
                            <td style="text-align: center;">
                                <strong>{{ number_format($totalWeightedMarks, 2) }}</strong>
                            </td>
                            <td colspan="2" style="text-align: left;">
                                <strong>MOYENNE:</strong>
                                <strong>{{ number_format($average, 2) }}</strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Additional Information Table -->
            <div class="info-section" style="font-size: 11px">
                <table class="subject-table" style="font-size: 11px;">
                    <thead>
                        <tr>
                            <th colspan="4" style="width: max-content;"><strong>DISCIPLINE</strong></th>
                            <th colspan="4" style="width: max-content;"><strong>TRAVAIL DE L'ELEVE</strong></th>
                            <th colspan="2" style="width: fit-content;"><strong>PROFILE DE CLASSE</strong></th>
                        </tr>
                        <tr>
                            <td>Abs. non. J. (h)</td>
                            <th></th>
                            <td>Avertissement de conduite</td>
                            <th></th>
                            <td style="width: 30px;">TOTAL GENERAL</td>
                            {{-- <th>{{ number_format($totalMarks, 2) }}</th> --}}
                            <th>{{ number_format($totalWeightedMarks, 2) }}</th>
                            <th colspan="2" style="width: 5px;">APPRECIATIONS</th>
                            <td>Moyenne Générale</td>
                            <th>{{ number_format($classAvg, 2) }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Abs just. (h)</td>
                            <td></td>
                            <td>Blâme de conduite</td>
                            <td></td>
                            <td style="width: 30px;">COEF</td>
                            <td style="text-align: center">{{ $totalCoef }}</td>
                            <td style="width: 5px;">CTBA</td>
                            <td></td>
                            <td>[Min – Max]</td>
                            <td style="text-align: center">{{ number_format($minTermAverage, 2) }} - {{ number_format($maxTermAverage, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Retards</td>
                            <td></td>
                            <td>Exclusions (jours)</td>
                            <td></td>
                            <td style="width: 30px;">MOYENNE TRIM</td>
                            <td style="text-align: center">
                                <strong>{{ number_format($average, 2) }}</strong>
                            </td>
                            <td style="width: 5px;">CA</td>
                            <td></td>
                            <td>Nombre de moyennes</td>
                            <td style="text-align: center">{{ $numberPassed }}</td>
                        </tr>
                        <tr>
                            <td>Consignes (heures)</td>
                            <td></td>
                            <td>Exclusion définitive</td>
                            <td></td>
                            <td style="width: 30px;">COTE</td>
                            <td style="text-align: center; font-weight:bold">{{ $termGrade }}</td>
                            <td style="width: 5px;">CNA</td>
                            <td></td>
                            <td>Taux de réussite</td>
                            <td style="text-align: center">{{ number_format($percentagePassed, 2) }} %</td>
                        </tr>
                        <tr style="height: 100px">
                            <td colspan="4" style="text-align: center;"><strong>Appréciation du travail de l’élève
                                    (points forts et points à améliorer)</strong> <br><br><br><br></td>
                            <td colspan="2" style="text-align: center;"><strong>Visa du parent /
                                    Tuteur</strong><br><br><br><br></td>
                            <td colspan="2" style="text-align: center;"><strong>Nom et visa du professeur
                                    principal</strong><br><br><br><br></td>
                            <td colspan="2" style="text-align: center;"><strong>Le Chef
                                    d’établissement</strong><br><br><br><br></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <footer class="footer">
                <hr>
                <p>BILINGUAL COLLEGE "LES PAPANETTES" | Address: [School Address] | Phone: 673 156 416 / 687 694 598 / 695 382 661</p>
            </footer>

            <div class="page-break"></div>
        @endforeach
    </div>
</body>


</html>
