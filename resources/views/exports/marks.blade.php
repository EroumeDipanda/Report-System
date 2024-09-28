<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        thead {
            background-color: #007bff;
            color: white;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        th {
            font-weight: bold;
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            table {
                border: none;
                box-shadow: none;
            }
            th, td {
                border: 1px solid #000;
            }
        }
    </style>
</head>
<body>

    <h1>Marks Export</h1>

    <table>
        <thead>
            <tr>
                <th>Matricule</th>
                <th>Student Name</th>
                <th>Class ID</th>
                <th>Subject ID</th>
                <th>Evaluation Number</th>
                <th>Mark</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($importedData as $data)
                @if ($data['classe_id'] == $classeId && $data['subject_id'] == $subjectId && $data['sequence'] == $sequence)
                    <tr>
                        <td>{{ $data['matricule'] }}</td>
                        <td>{{ $data['name_of_student'] }}</td>
                        <td>{{ $data['classe_id'] }}</td>
                        <td>{{ $data['subject_id'] }}</td>
                        <td>{{ $data['evaluation'] }}</td>
                        <td>{{ $data['marks'] }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

</body>
</html>
