<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CAMES STOCK - Gestion de Stock</title>
  @include('includes.seo')

  <!-- CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="{{asset('assets/images/cames_favIcon.png')}}"/>
  <link rel="manifest" href="/manifest.json">
  <meta name="theme-color" content="#0d6efd">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Hanken Grotesk', sans-serif;
    }

    /* === NAVBAR TRANSPARENTE === */
    .navbar {
      background-color: transparent !important;
      padding-top: 1rem;
      padding-bottom: 1rem;
      transition: all 0.3s ease;
      box-shadow: none;
    }
    .navbar.scrolled {
      background-color: #f8f9fa !important;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .navbar .navbar-brand img {
      margin-left: -10px; /* Logo un peu à gauche */
      transition: all 0.3s ease;
    }

    .navbar .btn,
    .navbar .language-card {
      margin-left: 10px;
    }

    /* === LISTES BANNIERE === */
    section ul {
      list-style-type: disc;
      padding-left: 20px;
    }
    section ul li {
      margin-bottom: 8px;
      font-size: 1.1rem;
      font-family: 'Hanken Grotesk', sans-serif;
      color: #000; /* points et texte noirs */
    }
    section ul li::marker {
      color: #000; /* points noirs */
      font-size: 1.2em;
    }

    /* === CARD OPTIONS DE LANGUE === */
    .language-card {
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 5px 12px;
      display: flex;
      align-items: center;
      cursor: pointer;
      background-color: #fff;
      position: relative;
      min-width: 120px;
    }
    .language-card img.flag {
      width: 20px;
      height: 15px;
      margin-right: 8px;
      object-fit: cover;
    }
    .language-card .dropdown-menu {
        top: 100%; /* Positionne le menu juste en dessous de la card */
        bottom: auto !important;
        margin-top: 5px; /* petit espace entre la card et le menu */
    }

    .language-card .dropdown-item img {
      width: 20px;
      height: 15px;
      margin-right: 8px;
    }

    /* === ADVANTAGE CARDS === */
    .advantage-card {
      background-color: #fff;
      border: none;
      border-radius: 12px;
      padding: 25px 20px;
      height: 100%;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: all 0.3s ease-in-out;
    }
    .advantage-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }
    .advantage-icon {
      font-size: 2.5rem;
      color: #0d6efd;
      margin-bottom: 15px;
    }

    /* === FOOTER STYLE ZERVANT === */
    footer {
      background-color: #f8f9fa;
      padding: 50px 20px 20px 20px;
      border-top: 1px solid #ddd;
    }
    footer .footer-links a {
      color: #333;
      text-decoration: none;
      margin-right: 20px;
      font-weight: 500;
    }
    footer .footer-links a:hover {
      text-decoration: underline;
    }
    footer .social-icons a {
      color: #333;
      margin-right: 15px;
      font-size: 1.2rem;
    }
    footer .social-icons a:hover {
      color: #0d6efd;
    }

    /* === GALERIE === */
    .gallery {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-template-rows: repeat(3, 150px);
      gap: 15px;
      justify-items: center;
      align-items: center;
    }
    .gallery img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 15px;
      display: block;
    }
    .center { grid-column: 2 / 3; grid-row: 2 / 3; }
    .top { grid-column: 2 / 3; grid-row: 1 / 2; }
    .bottom { grid-column: 2 / 3; grid-row: 3 / 4; }
    .left { grid-column: 1 / 2; grid-row: 2 / 3; }
    .right { grid-column: 3 / 4; grid-row: 2 / 3; }

    @media(max-width: 768px) {
      .gallery { grid-template-columns: repeat(2, 1fr); grid-template-rows: auto; }
      .center { grid-column: 1 / 3; grid-row: auto; }
      .navbar .d-flex.flex-lg-row { flex-direction: column !important; align-items: flex-start; }
      .language-card { margin-bottom: 10px; }
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
      <a class="navbar-brand" href="">
        <img src="{{asset('assets/images/cames_stock.png')}}" height="45px" width="45px" alt="">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navMenu">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center">
          <!-- Card Langue -->
         <div class="dropdown dropup language-card">
            <img src="https://flagcdn.com/16x12/fr.png" class="flag" alt="fr">
            <span>Français</span>
            <i class="mdi mdi-menu-down ms-auto"></i>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#"><img src="https://flagcdn.com/16x12/gb.png" class="flag"> English</a></li>
                <li><a class="dropdown-item" href="#"><img src="https://flagcdn.com/16x12/es.png" class="flag"> Español</a></li>
            </ul>
          </div>

          <button id="installBtn" class="btn btn-primary me-lg-2 mb-2 mb-lg-0">
            <i class="mdi mdi-download"></i> Installer l'application
          </button>

          <a class="btn btn-outline-primary rounded-pill mb-2 mb-lg-0 me-lg-2" href="{{route('login')}}">Connexion</a>
          <a class="btn btn-primary rounded-pill mb-2 mb-lg-0 me-lg-2" href="{{route('inscription')}}">Inscription</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- MAIN -->
  <main class="mt-5 pt-4">
    <!-- BANNIÈRE -->
    <section class="container-fluid bg-light py-5">
      <div class="row align-items-center">
        <div class="col-lg-6 text-center text-lg-start px-5">
          <h1 class="fw-bold mb-3">Votre outil gratuit pour des factures professionnelles,<br> simples et rapides</h1>
          <ul class="mb-4">
            <li>Générez vos devis et factures gratuitement</li>
            <li>Profitez d’une interface intuitive et rapide</li>
            <li>Créez des documents 100 % professionnels</li>
            <li>Inscrivez-vous en quelques clics</li>
            <li>Anticipez la réforme de la facturation électronique</li>
          </ul>
          <a class="btn btn-primary rounded-pill me-2" href="{{route('inscription')}}">Créer un compte gratuit</a>
        </div>
        <div class="col-lg-6 px-5 mt-4 mt-lg-0">
          <div class="gallery">
            <img src="{{asset('assets/images/info.jpg')}}" class="center shadow-sm" alt="" loading="lazy">
            <img src="{{asset('assets/images/banniere.jpg')}}" class="top shadow-sm" alt="" loading="lazy">
            <img src="{{asset('assets/images/magasin2.jpg')}}" class="bottom shadow-sm" alt="" loading="lazy">
            <img src="{{asset('assets/images/magasin.jpg')}}" class="left shadow-sm" alt="" loading="">
            <img src="{{asset('assets/images/boulangerie.jpg')}}" class="right shadow-sm" alt="">
          </div>
        </div>
      </div>
    </section>

    <div class="container-fluid px-5 mt-4">
        <section class="container-fluid bg-light py-5">
            <div id="featuresCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row align-items-center">
                        <div class="col-lg-6 text-center text-lg-start px-5">
                            <h3 class="fw-bold mb-3" style="font-family: 'Hanken Grotesk', sans-serif; font-weight: 700;">
                            Un Logiciel qui grandit avec vos besoins
                            </h3>
                            <p class="mb-4" style="font-family: 'Hanken Grotesk', sans-serif; font-weight: 500; font-size: 1.1rem;">
                            Camestocks s’adapte à votre entreprise et évolue avec vos besoins.
                            Dès aujourd’hui, commencez à gérer efficacement votre facturation avec nos solutions professionnelles.
                            Vous pouvez créer et envoyer vos factures en quelques clics, suivre vos ventes et optimiser votre gestion.
                            Au fur et à mesure que votre activité se développe, il vous suffit de choisir le pack qui correspond le mieux à vos objectifs.
                            </p>
                        </div>
                        <div class="col-lg-6 px-5 mt-4 mt-lg-0">
                            <div class="card border-0 shadow-lg rounded overflow-hidden">
                            <img src="{{asset('assets/images/banner.png')}}" alt="Autres fonctionnalités"
                                class="w-100" style="max-height: 400px; object-fit: cover;">
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="row align-items-center">
                        <div class="col-lg-6 text-center text-lg-start px-5">
                            <h3 class="fw-bold mb-3"> Gagnez du temps et en productivité </h3>
                            <p class="mb-4" style="font-family: 'Hanken Grotesk', sans-serif; font-weight: 500; font-size: 1.1rem;">
                                Passez moins de temps à gérer votre facturation pour vous concentrer sur l’essentiel !
                                En plus de pouvoir facturer en moins d’une minute, vous pouvez facilement suivre votre temps passé à travailler et voir en en clin d’œil comment votre entreprise se développe grâce au rapport des ventes.
                            </p>
                        </div>
                        <div class="col-lg-6 px-5 mt-4 mt-lg-0">
                            <div class="card border-0 shadow-lg rounded overflow-hidden">
                            <img src="{{asset('assets/images/humm.png')}}" alt="Gestion des stocks"
                                class="w-100" style="max-height: 400px; object-fit: cover;">
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="row align-items-center">
                        <div class="col-lg-6 text-center text-lg-start px-5">
                            <h3 class="fw-bold mb-3"> De l'aide dsponible pour creer vos factures facilement </h3>
                            <p class="mb-4" style="font-family: 'Hanken Grotesk', sans-serif; font-weight: 500; font-size: 1.1rem;">
                            L’interface simple et intuitive de Camestocks en fait un logiciel de facturation extrêmement simple d’utilisation.
                            Si toutefois vous avez des questions ou besoin d’aide, redigez la dans la rubrique suggestions et n’hésitez pas à contacter notre équipe de support qui vous aidera à profiter pleinement de votre compte camestoks.
                            </p>
                        </div>
                        <div class="col-lg-6 px-5 mt-4 mt-lg-0">
                            <div class="card border-0 shadow-lg rounded overflow-hidden">
                            <img src="{{asset('assets/images/info.jpg')}}" alt="Facturation rapide"
                                class="w-100" style="max-height: 400px; object-fit: cover;">
                            </div>
                        </div>
                        </div>
                    </div>

                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#featuresCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#featuresCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </section>


        <section class="text-center mb-5">
            <h3 class="mb-4">Pourquoi choisir notre application ?</h3>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="advantage-card">
                    <i class="mdi mdi-speedometer advantage-icon"></i>
                    <h5>Rapidité</h5>
                    <p>Gérez vos stocks en quelques clics, rapidement et efficacement.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="advantage-card">
                    <i class="mdi mdi-shield-check advantage-icon"></i>
                    <h5>Sécurité</h5>
                    <p>Vos données sont chiffrées et protégées grâce à des technologies avancées.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="advantage-card">
                    <i class="mdi mdi-cloud-upload advantage-icon"></i>
                    <h5>Sauvegarde Cloud</h5>
                    <p>Vos données sont sauvegardées automatiquement dans le cloud.</p>
                    </div>
                </div>
            </div>
       </section>

      <section class="text-center mb-5">
        <h3 class="mb-4">Découvrez notre application en vidéo</h3>
        <div class="mx-auto" style="max-width: auto; height: 300px;">
          <iframe src="https://www.youtube.com/embed/VIDÉO_ID" title="Présentation CAMES STOCK" allowfullscreen style="width: 100%; height: 100%; border: none;" loading="lazy"></iframe>
        </div>
      </section>

     <section class="text-center mb-5">
        <h3 class="mb-4"> Fonctionnalités Principales</h3>
        <div class="row g-4 justify-content-center">

          <div class="col-md-4">
            <div class="advantage-card">
              <i class="mdi mdi-account-check advantage-icon"></i>
              <h5>Gestion des clients</h5>
              <p>Suivez vos clients et historique de transactions.</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="advantage-card">
               <i class="mdi mdi-cash-multiple advantage-icon"></i>
               <h5>Suivi paiements</h5>
                <p>Ne manquez jamais un paiement grâce aux alertes automatiques.</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="advantage-card">
              <i class="mdi mdi-file-document advantage-icon"></i>
              <h5>Factures illimitées</h5>
              <p>Créez, personnalisez et envoyez vos factures facilement.</p>
            </div>
          </div>

        </div>
      </section>


    </div>
  </main>

    <footer class="text-white py-5" style="background-color: #0c408e;">
        <div class="container">
            <div class="row">

            <!-- RUBRIQUE 1 : PAGES -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="fw-bold mb-3">Pages</h5>
                <ul class="list-unstyled">
                <li><a href="#" class="text-white text-decoration-none">Accueil</a></li>
                <li><a href="#" class="text-white text-decoration-none">Fonctionnalités</a></li>
                <li><a href="#" class="text-white text-decoration-none">Tarifs</a></li>
                <li><a href="#" class="text-white text-decoration-none">Contact</a></li>
                </ul>
            </div>

            <!-- RUBRIQUE 2 : HORAIRES -->
            <div class="col-md-4 mb-4 mb-md-0">
                <h5 class="fw-bold mb-3">Horaires</h5>
                <p class="mb-1">Lundi - Vendredi : 08h - 17h</p>
                <p class="mb-1">Samedi : 09h - 14h</p>
                <p class="mb-0">Dimanche : Fermé</p>
            </div>

            <!-- RUBRIQUE 3 : JOURS -->
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">Disponibilité</h5>
                <p class="mb-1">✔️ Ouvert 7j/7 en ligne</p>
                <p class="mb-1">✔️ Support réactif</p>
                <p class="mb-0">✔️ Assistance rapide</p>
            </div>

            </div>

            <hr class="border-light my-4">

            <div class="row">
            <div class="col-md-6">
                <p class="mb-0">© {{ date('Y') }} CAMES ORGANISATION. Tous droits réservés.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-white me-3"><i class="mdi mdi-facebook"></i></a>
                <a href="#" class="text-white me-3"><i class="mdi mdi-twitter"></i></a>
                <a href="#" class="text-white"><i class="mdi mdi-linkedin"></i></a>
            </div>
            </div>
        </div>
    </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar scroll
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
      if(window.scrollY > 10) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // Dropdown langue
    const languageCard = document.querySelector('.language-card');
    const dropdownMenu = languageCard.querySelector('.dropdown-menu');
    languageCard.addEventListener('click', () => {
      dropdownMenu.classList.toggle('show');
    });
    document.addEventListener('click', e => {
      if(!languageCard.contains(e.target)) {
        dropdownMenu.classList.remove('show');
      }
    });
  </script>
</body>
</html>




