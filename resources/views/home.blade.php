<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> CAMES STOCK - Gestion de Stock</title>
  @include('includes.seo')

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="{{asset(path: 'assets/images/cames_favIcon.png')}}"/>

  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Navbar */
    .navbar {
      padding-top: 1.2rem;
      padding-bottom: 1.2rem;
    }

    .navbar-brand span {
      font-weight: bold;
      color: #0d6efd;
      font-size: 1.4rem;
    }

    /* Carousel */
    .carousel img {
      width: 100%;
      height: 500px;
      object-fit: cover;
    }

    /* Section title */
    section h3 {
      font-weight: 700;
      color: #333;
    }

    /* Cards */
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

    /* Footer */
    footer {
      background-color: #fff;
      padding: 20px 0;
      text-align: center;
      border-top: 1px solid #dee2e6;
      font-size: 0.9rem;
    }

    /* Responsive tweaks */
    @media (max-width: 768px) {
      .carousel img {
        height: 300px;
      }
      .navbar-collapse {
        background-color: #fff;
        padding: 1rem;
      }
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
   <div class="container">
  <a class="navbar-brand" href="#">
    <span>Star</span>Admin
  </a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

    <div class="collapse navbar-collapse justify-content-end" id="navMenu">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center">
            <a class="btn btn-outline-primary rounded-pill mb-2 mb-lg-0 me-lg-2" href="{{route('login')}}">Connexion</a>
            <a class="btn btn-primary rounded-pill mb-2 mb-lg-0 me-lg-2" href="{{route('inscription')}}">Inscription</a>
            <a class="btn btn-outline-secondary rounded-pill" href="{{asset('assets/videos/demo.mp4')}}" target="_blank">Demo d'utilisation</a>
        </div>
    </div>


  </nav>

  <main class="mt-5 pt-4">

    <div id="carouselExampleIndicators" class="carousel slide mb-5" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="{{asset('assets/images/banniere_1.jpg')}}" class="d-block w-100" alt="Gestion de stock - Rapidité" loading="lazy">
        </div>
        <div class="carousel-item">
          <img src="{{asset('assets/images/banniere_2.jpg')}}" class="d-block w-100" alt="Sécurité des données" loading="lazy">
        </div>
        <div class="carousel-item">
          <img src="{{asset('assets/images/banniere_3.jpg')}}" class="d-block w-100" alt="Interface responsive" loading="lazy">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>

    <div class="container-fluid px-5 mt-4">
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
              <i class="mdi mdi-cellphone advantage-icon"></i>
              <h5>Responsive</h5>
              <p>Accessible depuis tout appareil : mobile, tablette ou ordinateur.</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="advantage-card">
              <i class="mdi mdi-cloud-upload advantage-icon"></i>
              <h5>Sauvegarde Cloud</h5>
              <p>Vos données sont sauvegardées automatiquement dans le cloud.</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="advantage-card">
              <i class="mdi mdi-chart-bar advantage-icon"></i>
              <h5>Statistiques</h5>
              <p>Analysez vos performances avec des graphiques en temps réel.</p>
            </div>
          </div>

          <div class="col-md-4">
            <div class="advantage-card">
              <i class="mdi mdi-account-multiple advantage-icon"></i>
              <h5>Multi-utilisateur</h5>
              <p>Travaillez en équipe grâce à une gestion avancée des accès.</p>
            </div>
          </div>

        </div>
      </section>
    </div>

  </main>

  <footer>
    <div class="container">
      <p class="mb-0 text-muted">© {{ date('Y') }} CAMES ORGANISATION. Tous droits réservés.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

