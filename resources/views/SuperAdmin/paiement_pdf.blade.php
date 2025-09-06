<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport Abonnements {{ $annee }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Rapport des abonnements - {{ $annee }}</h2>
    <table>
        <thead>
            <tr>
                <th>Mois</th>
                <th>Total Récolté (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($paiementsParMois as $paiement)
                <tr>
                    <td>{{ \Carbon\Carbon::create()->month($paiement->mois)->locale('fr')->monthName }}</td>
                    <td>{{ number_format($paiement->total, 0, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
