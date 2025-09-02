<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Nouveau Produit </title>
</head>
<body>
    <h2>Un nouveau produit est disponible dans votre boutique préférée : {{$nom_boutique}} !</h2>

    <p><strong>Nom :</strong> {{ $product->nom_produit }}</p>
    <p><strong>Prix :</strong> {{ $product->prix_vente }} FCFA</p>
    <p><strong>Description :</strong> {{ $product->description }}</p>
    @if ($product->image_produit)
    <img src="{{asset('assets/images/'.$product->image_produit)}}" height="200px" width="200px" alt="">
    @else
    <p>pas d'image</p>
    @endif
</body>
</html>
