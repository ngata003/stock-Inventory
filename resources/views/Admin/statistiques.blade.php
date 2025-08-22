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
    <link rel="shortcut icon" href="{{asset('assets/images/cames_favIcon.png')}}" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body class="with-welcome-text">
    <div class="container-scroller">
      @include('includes.user_profil_include')
      <div class="container-fluid page-body-wrapper">
       @include('includes.nav_include')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-12">
                <div class="home-tab">
                  <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div>
                      <div class="btn-wrapper d-flex align-items-center gap-2">
                        <a href="#" class="btn btn-success align-items-center"><i class="icon-download"></i> Export Commandes </a>
                        <a href="#" class="btn btn-primary text-white me-0"><i class="icon-download"></i> Export Ventes </a>
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
                              <p class="statistics-title"> Nbre Employés </p>
                              <h3 class="rate-percentage">{{$nb_employes}}</h3>
                            </div>
                            <div>
                              <p class="statistics-title"> Nbre Coursiers </p>
                              <h3 class="rate-percentage">{{$nb_coursiers}}</h3>
                            </div>
                            <div>
                              <p class="statistics-title"> Chiffre d'Affaire</p>
                              <h3 class="rate-percentage">{{$chffreA}} FCFA</h3>
                            </div>
                            <div class="d-none d-md-block">
                              <p class="statistics-title"> Nbre Ventes  </p>
                              <h3 class="rate-percentage">{{$nb_ventes}}</h3>
                            </div>
                            <div class="d-none d-md-block">
                              <p class="statistics-title"> Total commandes Validées </p>
                              <h3 class="rate-percentage">{{$nb_commandes_val}}</h3>
                            </div>
                            <div class="d-none d-md-block">
                              <p class="statistics-title"> Total Commandes non validées  </p>
                              <h3 class="rate-percentage">{{$nb_commandes_inval}}</h3>
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
                                      <h4 class="card-title card-title-dash"> ventes mensuelles </h4>
                                      <h5 class="card-subtitle card-subtitle-dash"> total ventes par mois  </h5>
                                    </div>
                                    <div id="performanceLine-legend"></div>
                                  </div>
                                  <div class="chartjs-wrapper mt-4">
                                    <canvas id="ventesLine" width=""></canvas>
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
                                          <h4 class="card-title card-title-dash">Top Produits</h4>
                                        </div>
                                      </div>
                                      <div class="mt-3">
                                        @foreach ($top_produits as $t_prod )
                                            <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                                <div class="d-flex">
                                                    <div class="wrapper ms-3">
                                                    <p class="ms-1 mb-1 fw-bold">{{$t_prod->nom_produit}} </p>
                                                    </div>
                                                </div>
                                                <div class="text-primary text-small fw-bold"> {{$t_prod->total_montant}}  FCFA</div>
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
                      <div class="row">
                        <div class="col-lg-8 d-flex flex-column">
                          <div class="row flex-grow">
                            <div class="col-12 grid-margin stretch-card">
                              <div class="card card-rounded">
                               <div class="card-body">
                                  <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                      <h4 class="card-title card-title-dash"> commandes mensuelles </h4>
                                      <h5 class="card-subtitle card-subtitle-dash"> produit ventes par mois  </h5>
                                    </div>
                                    <div id="performanceLine-legend"></div>
                                  </div>
                                 <div class="chartjs-wrapper mt-4" style="height: 300px;">
                                    <canvas id="commandesLine"></canvas>
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
                                          <h4 class="card-title card-title-dash">Top Clients</h4>
                                        </div>
                                      </div>
                                      <div class="mt-3">
                                        @foreach ($top_clients as $tclt )
                                            <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                                <div class="d-flex">
                                                    <div class="wrapper ms-3">
                                                    <p class="ms-1 mb-1 fw-bold">{{$tclt->client_identifiant}}</p>
                                                    </div>
                                                </div>
                                                <div class="text-primary text-small fw-bold">{{$tclt->total_montant}} FCFA</div>
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
        const ctx = document.getElementById('ventesLine').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                ],
                datasets: [{
                    label: 'ventes',
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('commandesLine');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: [
                            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
                        ],
                        datasets: [{
                            label: 'Commandes',
                            data: @json($donnees),
                            borderColor: '#0000FF',
                            borderWidth: 2,
                            fill: false,
                            tension: 0.4,
                            pointRadius: 5,
                            pointBackgroundColor: '#0000FF'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                enabled: true,
                                callbacks: {
                                    label: function(context) {
                                        return context.parsed.y.toLocaleString() + " FCFA";
                                    }
                                }
                            }
                        },
                        scales: {
                            y: { beginAtZero: true }
                        }
                    }
                });
            }
        });
    </script>
  </body>
</html>
