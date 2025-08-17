<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"></head>
<body>
    <p>Bonjour {{ $data['nom_client'] }},</p>
    <p>Veuillez trouver en pièce jointe votre facture n° <strong>#{{ $data['id_facture'] }}</strong>.</p>
    <p>Merci pour votre confiance.</p>
</body>
</html>
