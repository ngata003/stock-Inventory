<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> CAMES STOCK </title>
    <link rel="stylesheet" href="{{asset('assets/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/typicons/typicons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/js/select.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/cames_favIcon.png')}}"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body class="with-welcome-text">
    <div class="container-scroller">
      @include('includes.user_profil_include')
      <div class="container-fluid page-body-wrapper">
       @include('includes.adminNavig')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-12">
                <div class="home-tab">
                  <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div>
                        <div class="btn-wrapper d-flex align-items-center gap-2">
                            <a href="#" class="btn btn-outline-dark"><i class="icon-printer"></i> Télécharger PDF</a>
                            <a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i> Exporter en Excel</a>
                            <div class="dropdown">
                                <a class="btn btn-outline-white dropdown-toggle" href="#" role="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                Selectionner Mois
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                    <li>
                                        <a class="dropdown-item" href="#"> Janvier </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"> Fevrier </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"> Mars </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"> Avril </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"> Mai </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"> Juin </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"> Juillet </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"> Aout </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"> Septembre </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"> Octobre </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"> Novembre </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"> Decembre </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="statistics-details d-flex align-items-center justify-content-between">
                            <div>
                              <p class="statistics-title"> Nbre Boutiques </p>
                              <h3 class="rate-percentage">{{$nb_boutiques}}</h3>
                            </div>
                            <div>
                              <p class="statistics-title"> Chiffre d'Affaire </p>
                              <h3 class="rate-percentage">{{$chiffreA}} FCFA </h3>
                            </div>
                            <div>
                              <p class="statistics-title"> Total Abonnement mois </p>
                              <h3 class="rate-percentage">{{$chiffreM}} FCFA </h3>
                            </div>
                            <div class="d-none d-md-block">
                              <p class="statistics-title"> Nbre abonnements </p>
                              <h3 class="rate-percentage">{{$nb_abonnements}}</h3>
                            </div>
                            <div class="d-none d-md-block">
                              <p class="statistics-title"> Nbre abonnements actifs </p>
                              <h3 class="rate-percentage">{{$abonnements_actifs}}</h3>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-8 d-flex flex-column">
                          <div class="row flex-grow">
                            <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                              <div class="card card-rounded">
                                <div class="card-body">
                                  <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                      <h4 class="card-title card-title-dash"> Abonnements mensuels </h4>
                                      <h5 class="card-subtitle card-subtitle-dash"> total abonnements par mois  </h5>
                                    </div>
                                    <div id="performanceLine-legend"></div>
                                  </div>
                                  <div class="chartjs-wrapper mt-4">
                                    <canvas id="paiementsLine" style="width:100% !important; height:300px !important;"></canvas>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4 d-flex flex-column">
                          <div class="row flex-grow">
                            <div class="col-12 grid-margin stretch-card">
                              <div class="card card-rounded">
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-lg-12">
                                      <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                          <h4 class="card-title card-title-dash">Top Boutiques </h4>
                                        </div>
                                      </div>
                                      <div class="mt-3">
                                        @foreach ($boutiques as $btq )
                                            <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                                <div class="d-flex">
                                                    <img class="img-sm rounded-10" src="{{asset('assets/images/'.$btq->logo)}}" alt="profile">
                                                    <div class="wrapper ms-3">
                                                        <p class="ms-1 mb-1 fw-bold"> Boutique: {{$btq->nom_boutique}}</p>
                                                        <small class="text-black mb-0"> Createur : {{$btq->createur->name}}</small>
                                                    </div>
                                                </div>
                                                <div class="text-primary text-small fw-bold">{{$btq->total_ventes}} FCFA</div>
                                            </div>
                                        @endforeach
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
         @include('includes.footer')
        </div>
      </div>
    </div>
    <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/vendors/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset('assets/vendors/progressbar.js/progressbar.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>
    <script src="{{asset('assets/js/jquery.cookie.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/dashboard.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('paiementsLine').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ],
                datasets: [{
                    label: 'Paiements',
                    data: @json($data),
                    borderColor: '#0000FF',
                    borderWidth: 2,
                    fill: false,
                    tension: 0.4,
                    pointRadius: 5,                // points visibles
                    pointBackgroundColor: '#0000FF'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,       // permet de bien remplir la card
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y.toLocaleString() + " FCFA"; // formatage
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
  </body>
</html>
