<!-- resources/views/emails/file_uploaded.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fichier Chargé</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 10px;">
        <img src="{{ asset('path-to-your-logo/logo.png') }}" alt="Logo" style="max-width: 150px; margin-bottom: 20px;">

        <h2 style="color: #333;">Bonjour Admin,</h2>
        <p style="font-size: 16px; color: #555;">
            Un nouveau fichier a été chargé.
        </p>
        <p>
            <strong>Nom du fichier:</strong> {{ $fileName }}<br>
            <strong>Type de fichier:</strong> {{ $fileType }}<br>
            <strong>Chargé par:</strong> {{ $userName }}
        </p>

        <a href="{{ route('dashboard') }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px; margin-top: 20px;">
            Voir les fichiers
        </a>

        <p style="font-size: 14px; color: #999; margin-top: 20px;">Merci d'utiliser notre application !</p>
    </div>
</body>
</html>
