
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> CAMES STOCK  </title>
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
        @include('includes.adminNavig')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-12">
                <div class="home-tab">
                  <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    <div>
                        <div class="btn-wrapper d-flex align-items-center gap-2">
                            <div class="dropdown ms-2">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="categoryDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    Choisir un mois
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('statistiques_boutiques', ['mois' => $i  , 'id' => $id]) }}">
                                                {{ \Carbon\Carbon::create()->month($i)->locale('fr')->monthName }}
                                            </a>
                                        </li>
                                    @endfor
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
                              <p class="statistics-title"> chiffre d'affaires </p>
                              <h3 class="rate-percentage">{{$chiffreA}}</h3>
                              <p class="text-danger d-flex"></p>
                            </div>
                            <div>
                              <p class="statistics-title"> Total Ventes </p>
                              <h3 class="rate-percentage">{{$nb_ventes}}</h3>
                              <p class="text-success d-flex"></p>
                            </div>
                            <div>
                              <p class="statistics-title"> Benefice du mois </p>
                              <h3 class="rate-percentage">{{$benefice ?? 0}}</h3>
                              <p class="text-danger d-flex"></p>
                            </div>
                            <div class="d-none d-md-block">
                              <p class="statistics-title"> Total Commandes </p>
                              <h3 class="rate-percentage">{{$nb_commandes}}</h3>
                              <p class="text-success d-flex"></p>
                            </div>
                            <div class="d-none d-md-block">
                              <p class="statistics-title"> Commandes validées </p>
                              <h3 class="rate-percentage">{{$nb_commandes_validees}}</h3>
                              <p class="text-danger d-flex"></p>
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
                                    <canvas id="ventesLine" style="width:100% !important; height:300px !important;"></canvas>
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
                                          <h4 class="card-title card-title-dash">Top Produits </h4>
                                        </div>
                                      </div>
                                      @foreach ($top_produits as $t_prod)
                                       <div class="mt-3">
                                            <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                                <div class="d-flex">
                                                    <div class="wrapper ms-3">
                                                        <p class="ms-1 mb-1 fw-bold">{{$t_prod->nom_produit}}</p>
                                                    </div>
                                                </div>
                                                <div class="text-primary text-small fw-bold">{{$t_prod->total_montant}}</div>
                                            </div>
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
                                      @foreach ($top_clients as $t_clt )
                                        <div class="mt-3">
                                            <div class="wrapper d-flex align-items-center justify-content-between py-2 border-bottom">
                                                <div class="d-flex">
                                                    <div class="wrapper ms-3">
                                                    <p class="ms-1 mb-1 fw-bold">{{$t_clt->client_identifiant}}</p>
                                                    </div>
                                                </div>
                                                <div class="text-primary text-small fw-bold">{{$t_clt->total_montant}}</div>
                                            </div>
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
