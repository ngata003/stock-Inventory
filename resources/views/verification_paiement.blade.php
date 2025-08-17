<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verification de paiement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .container {
            text-align: center;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%; /* Responsive width */
        }

        p {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        a:hover {
            color: #0056b3;
        }

        /* Media query for smaller screens */
        @media (max-width: 768px) {
            p {
                font-size: 1.2em;
            }

            .container {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            p {
                font-size: 1em;
            }

            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Laisser un peu de temps à l'administrateur pour vérifier le paiement , si ca persiste laissez un message ici : <a href="https://wa.me/237678650315" target="_blank" class="btn btn-success"><i class="fab fa-whatsapp"></i> WhatsApp</a></p>
        @if (!Auth::user()->abonnement_valide || now()->gt(Auth::user()->date_expiration))
            <p>attendez encore la validation du proprietaire.</p>
        @else
            <p>Pour accéder à l'espace boutiques, <a href="{{route('boutiques_view')}}">cliquez ici</a>.</p>
        @endif

    </div>
</body>
</html>
