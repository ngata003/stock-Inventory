<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Informations de connexion</title>
</head>
<body>
    <h2>Bonjour {{ $name }},</h2>

    <p>Votre compte a été créé avec succès.</p>

    <p><strong>Email :</strong> {{ $email }}</p>
    <p><strong>Mot de passe :</strong> {{ $password }}</p>

    <p>Vous pouvez vous connecter à la plateforme en cliquant sur le lien suivant :</p>
    <p><a href="{{ $link }}">{{ $link }}</a></p>

    <br>
    <p>Cordialement,</p>
    <p>L'équipe de support</p>
</body>
</html>
