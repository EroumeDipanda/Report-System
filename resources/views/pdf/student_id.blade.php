<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School ID Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .id-card {
            border: 2px solid #333;
            border-radius: 10px;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            width: 300px; /* Set a fixed width for the card */
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 10px;
        }
        .student-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-top: 1px solid #ccc;
            border-bottom: 1px solid #ccc;
        }
        .student-image {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .student-image img {
            width: 80px;
            height: 80px;
            margin-bottom: 5px; /* Space between photo and signature */
            border: 1px dashed #aaa; /* Placeholder style */
        }
        .student-detail {
            flex-grow: 1;
            text-align: left; /* Align text to the left */
            margin-left: 10px; /* Space between image and details */
        }
        .id-card h2 {
            margin: 5px 0;
            font-size: 1.5em;
            text-align: center;
        }
        .id-card p {
            margin: 5px 0;
        }
        .school-name {
            font-weight: bold;
            font-size: 1.2em;
            text-align: center;
            flex-grow: 1;
        }
        footer {
            text-align: center;
            padding: 5px 0;
        }
    </style>
</head>
<body>

    <div class="id-card">
        <header>
            <img src="{{ $logoPath }}" alt="School Logo" style="height: 50px;"> <!-- Placeholder for school logo -->
            <h3 class="school-name">SCHOOL NAME</h3>
            <img src="{{ $logoPath }}" alt="Cameroon Logo" style="height: 50px;"> <!-- Placeholder for Cameroon logo -->
        </header>

        <div class="student-container">
            <div class="student-image">
                <img src="https://via.placeholder.com/80" alt="Student Photo"> <!-- Placeholder for student photo -->
                <p><strong>Principal Signature</strong></p> <!-- Signature label -->
            </div>
            <div class="student-detail">
                <p><strong>Name:</strong> John Doe</p>
                <p><strong>Grade:</strong> 10</p>
                <p><strong>ID:</strong> 123456</p>
                <p><strong>Year:</strong> 2024</p>
            </div>
        </div>

        <footer>
            <p>School Address</p>
        </footer>
    </div>

</body>
</html>
