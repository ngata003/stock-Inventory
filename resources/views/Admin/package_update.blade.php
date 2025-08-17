<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CAMES STOCK - Packages</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6C5CE7;
            --secondary-color: #A29BFE;
            --success-color: #00B894;
            --warning-color: #FDCB6E;
            --danger-color: #E84393;
            --light-bg: #F8F9FA;
            --dark-text: #2D3436;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .container-scroller {
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .page-body-wrapper {
            width: 100%;
            padding: 20px;
        }

        .content-wrapper {
            background: transparent;
        }

        .package-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            height: 100%;
        }

        .package-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .package-card.featured {
            border-color: var(--primary-color);
            position: relative;
        }

        .package-card.featured::before {
            content: "POPULAIRE";
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--primary-color);
            color: white;
            padding: 5px 20px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
        }

        .package-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .package-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .package-name {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--dark-text);
            margin-bottom: 0.5rem;
        }

        .package-price {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .package-period {
            color: #666;
            font-size: 0.9rem;
        }

        .package-features {
            list-style: none;
            padding: 0;
            margin: 2rem 0;
        }

        .package-features li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 2rem;
        }

        .package-features li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: var(--success-color);
            font-weight: bold;
        }

        .package-features li.unavailable {
            color: #999;
            text-decoration: line-through;
        }

        .package-features li.unavailable:before {
            content: "✗";
            color: var(--danger-color);
        }

        .btn-pack {
            width: 100%;
            padding: 1rem;
            border-radius: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-basic {
            background: linear-gradient(135deg, #74b9ff, #0984e3);
            color: white;
        }

        .btn-basic:hover {
            background: linear-gradient(135deg, #0984e3, #74b9ff);
            transform: translateY(-2px);
        }

        .btn-pro {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .btn-pro:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
        }

        .btn-enterprise {
            background: linear-gradient(135deg, #fd79a8, #e84393);
            color: white;
        }

        .btn-enterprise:hover {
            background: linear-gradient(135deg, #e84393, #fd79a8);
            transform: translateY(-2px);
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 3rem;
        }

        .brand-logo img {
            max-width: 200px;
        }

        .page-title {
            text-align: center;
            color: white;
            margin-bottom: 3rem;
        }

        .page-title h2 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .page-title p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .package-card {
                padding: 1.5rem;
                margin-bottom: 1.5rem;
            }

            .page-title h2 {
                font-size: 2rem;
            }

            .package-price {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            <div class="content-wrapper">
                <div class="page-title">
                    <h2>Choisissez Un autre Package</h2>
                    <p>Sélectionnez le plan qui correspond le mieux à vos besoins</p>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-4">
                            <form  action="{{route('update_plan')}}" method="POST">
                                @csrf
                                <input type="hidden" name="type_package" value="basic">
                                <input type="hidden" name="prix_abonnement" value="17">
                                <input type="hidden" name="nb_coursiers" value="3">
                                <input type="hidden" name="nb_employes" value="5">
                                <input type="hidden" name="nb_boutiques" value="1">


                                <div class="package-card">
                                    <div class="package-header">
                                        <div class="package-icon">
                                            <i class="fas fa-box"></i>
                                        </div>
                                        <div class="package-name">BASIC</div>
                                        <div class="package-price"> 17€ </div>
                                        <div class="package-period">par mois</div>
                                    </div>

                                    <ul class="package-features">
                                        <li> maxi 5 Employés </li>
                                        <li>Rapports en temps réel</li>
                                        <li> maxi 3 coursiers </li>
                                        <li>Support par email</li>
                                        <li> 1 boutique max </li>
                                    </ul>
                                    <input type="submit" value="Choisir Basic" class="btn btn-pack btn-basic">
                                </div>
                            </form>

                        </div>

                        <div class="col-lg-4 col-md-6 mb-4">
                            <form action="{{route('update_plan')}}" method="POST">
                                @csrf
                                <input type="hidden" name="type_package" value="regular">
                                <input type="hidden" name="prix_abonnement" value="25">
                                <input type="hidden" name="nb_coursiers" value="6">
                                <input type="hidden" name="nb_employes" value="10">
                                <input type="hidden" name="nb_boutiques" value="2">

                                <div class="package-card featured">
                                    <div class="package-header">
                                        <div class="package-icon">
                                            <i class="fas fa-crown"></i>
                                        </div>
                                        <div class="package-name">REGULAR</div>
                                        <div class="package-price"> 25€ </div>
                                        <div class="package-period">par mois</div>
                                    </div>

                                    <ul class="package-features">
                                        <li> maxi 10 Employés par boutique </li>
                                        <li> Rapports en temps réel </li>
                                        <li> maxi 6 coursiers par boutique  </li>
                                        <li> Support par email </li>
                                        <li>support telephonique </li>
                                        <li> 2 boutiques max </li>
                                        <li> formation personnalisée </li>
                                    </ul>

                                    <input type="submit" value="Choisir regular" class="btn btn-pack btn-pro">
                                </div>
                            </form>
                        </div>

                        <div class="col-lg-4 col-md-6 mb-4">
                            <form action="{{route('update_plan')}}" method="POST">
                                @csrf
                                <input type="hidden" name="type_package" value="pro">
                                <input type="hidden" name="prix_abonnement" value="50">
                                <input type="hidden" name="nb_coursiers" value="100">
                                <input type="hidden" name="nb_employes" value="1000">
                                <input type="hidden" name="nb_boutiques" value="3">

                                <div class="package-card">
                                    <div class="package-header">
                                        <div class="package-icon">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <div class="package-name"> PRO </div>
                                        <div class="package-price">50€</div>
                                        <div class="package-period">par mois</div>
                                    </div>

                                    <ul class="package-features">
                                        <li> max 1000 employés  </li>
                                        <li> Rapports en temps réel </li>
                                        <li> 100 coursiers </li>
                                        <li> Support par email </li>
                                        <li> support telephonique </li>
                                        <li> formation personnalisée </li>
                                        <li> 3 boutiques max </li>
                                    </ul>
                                    <input type="submit" value="Choisir Pro" class="btn btn-pack btn-enterprise">
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animation au scroll
        window.addEventListener('scroll', function() {
            const cards = document.querySelectorAll('.package-card');
            cards.forEach(card => {
                const rect = card.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }
            });
        });

        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.package-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
    </script>
</body>
</html>
