<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #{{ $invoice->id}}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
            line-height: 1.4;
        }

        /* Header avec logo centré */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
        }

        .logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 10px 0 5px 0;
            font-size: 18px;
            color: #333;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        /* Container pour les infos - utilise table au lieu de flexbox */
        .info-container {
            width: 100%;
            margin-bottom: 25px;
        }

        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 20px 0;
        }

        .info-table td {
            width: 50%;
            vertical-align: top;
            padding: 15px;
            border: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .info-title {
            font-weight: bold;
            font-size: 14px;
            color: #333;
            margin-bottom: 10px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .info-content {
            font-size: 12px;
            line-height: 1.6;
        }

        /* Tableau des produits */
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .products-table th {
            background-color: #f0f0f0;
            border: 1px solid #333;
            padding: 10px 8px;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
        }

        .products-table td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
            font-size: 11px;
        }

        .products-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Section totaux intégrée dans le tableau principal */
        .products-table tfoot td {
            border: 1px solid #333;
            padding: 10px 8px;
            font-weight: bold;
        }

        .products-table .totals-row-1 td {
            background-color: #f9f9f9;
            font-size: 12px;
        }

        .products-table .totals-row-2 td {
            background-color: #ffffff;
            font-size: 12px;
        }

        .products-table .total-final-row td {
            background-color: #f0f0f0;
            font-size: 13px;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            text-align: center;
            font-size: 11px;
            color: #666;
        }

        /* Styles pour l'impression/PDF */
        @media print {
            body {
                margin: 0;
                padding: 15px;
            }

            .header {
                page-break-inside: avoid;
            }

            .products-table {
                page-break-inside: auto;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('assets/images/' . $boutique->logo) }}" class="logo" alt="Logo">
        <h2>FACTURE N° {{ $invoice->id }}</h2>
        <p>{{ $invoice->date }}</p>
    </div>

    <div class="info-container">
        <table class="info-table">
            <tr>
                <td>
                    <div class="info-title">Informations de l'entreprise</div>
                    <div class="info-content">
                        <strong>Email :</strong> {{ $boutique->email }}<br>
                        <strong>Contact :</strong> {{ $boutique->telephone }}<br>
                        <strong>Site web :</strong> {{ $boutique->site_web }}<br>
                        <strong>Localisation :</strong> {{ $boutique->adresse }}<br>
                        <strong>NUI :</strong> {{ $boutique->nui }}
                    </div>
                </td>
                <td>
                    <div class="info-title">Informations du client</div>
                    <div class="info-content">
                        <strong>Nom :</strong> {{ $invoice['nom_client'] ?? $invoice['contact_client'] }}<br>
                        <strong>Email :</strong> {{ $invoice['email_client'] ?? '---' }}<br>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Tableau des produits avec totaux intégrés -->
    <table class="products-table">
        <thead>
            <tr>
                <th style="width: 40%;">Produit</th>
                <th style="width: 15%;">Quantité</th>
                <th style="width: 20%;">Prix Unitaire</th>
                <th style="width: 25%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ventes as $vente)
                <tr>
                    <td style="text-align: left;">{{ $vente->nom_produit }}</td>
                    <td>{{ $vente->qte }}</td>
                    <td>{{ number_format($vente->prix_unitaire, 0, ',', ' ') }} FCFA</td>
                    <td>{{ number_format($vente->montant_total, 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="totals-row-2">
                <td colspan="3" style="text-align: right;">TOTAL ACHAT</td>
                <td style="text-align: center;">{{ number_format($invoice->montant_total, 0, ',', ' ') }} FCFA</td>
            </tr>
             <tr class="total-final-row">
                <td colspan="3" style="text-align: right;">reduction</td>
                <td style="text-align: center;">{{ number_format($invoice->reduction, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr class="totals-row-1">
                <td colspan="3" style="text-align: right;">Montant a payer</td>
                <td style="text-align: center;">{{ number_format($invoice->montant_total - $invoice->reduction, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tfoot>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>{{ $boutique->site_web }} | {{ $boutique->adresse}}</p>
        <p>Merci pour votre confiance</p>
    </div>

</body>
</html>
