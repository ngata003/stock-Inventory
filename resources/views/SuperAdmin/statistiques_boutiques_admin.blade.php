
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin2 </title>
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
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body class="with-welcome-text">
    <div class="container-scroller">
      @include('includes.user_profil_include')
      <div class="container-fluid page-body-wrapper">
        @include('superAdmin.includes_nav')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-12">
                <div class="home-tab">
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
                                      <h4 class="card-title card-title-dash"> Ventes mensuelles </h4>
                                      <h5 class="card-subtitle card-subtitle-dash">Résumé de toutes les ventes par mois</h5>
                                    </div>
                                    <div id="performanceLine-legend"></div>
                                  </div>
                                   <div class="chartjs-wrapper mt-4">
                                        <canvas id="ventesParMoisChart" height="160"></canvas>
                                    </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4 d-flex flex-column">
                          <div class="row flex-grow">
                            <div class="col-md-6 col-lg-12 grid-margin stretch-card">
                              <div class="card card-rounded">
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-lg-12">
                                      <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div>
                                          <h4 class="card-title card-title-dash"> Top Produits</h4>
                                        </div>
                                        <div>
                                        <div class="dropdown">
                                            <button class="btn btn-light dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> This month </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <h6 class="dropdown-header">Settings</h6>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Separated link</a>
                                            </div>
                                        </div>
                                    </div>
                                      </div>
                                      <div class="mt-3">
                                        <canvas id="leaveReport"></canvas>
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
                                      <h4 class="card-title card-title-dash">Market Overview</h4>
                                      <p class="card-subtitle card-subtitle-dash">Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                                    </div>
                                    <div>
                                      <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> This month </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                          <h6 class="dropdown-header">Settings</h6>
                                          <a class="dropdown-item" href="#">Action</a>
                                          <a class="dropdown-item" href="#">Another action</a>
                                          <a class="dropdown-item" href="#">Something else here</a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#">Separated link</a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                    <div class="d-sm-flex align-items-center mt-4 justify-content-between">
                                      <h2 class="me-2 fw-bold">$36,2531.00</h2>
                                      <h4 class="me-2">USD</h4>
                                      <h4 class="text-success">(+1.37%)</h4>
                                    </div>
                                    <div class="me-3">
                                      <div id="marketingOverview-legend"></div>
                                    </div>
                                  </div>
                                  <div class="chartjs-bar-wrapper mt-3">
                                    <canvas id="marketingOverview"></canvas>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4 d-flex flex-column">
                          <div class="row flex-grow">
                            <div class="col-md-6 col-lg-12 grid-margin stretch-card">
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
                                        <canvas id="clientsReport"></canvas>
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
        const ctx = document.getElementById('leaveReport').getContext('2d');
        const dataLabels = @json($top_produits->pluck('nom_produit'));
        const dataValues = @json($top_produits->pluck('total_vendus'));

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dataLabels,
                datasets: [{
                    label: 'Quantité vendue',
                    data: dataValues,
                    backgroundColor: '#198754',  // vert Bootstrap bg-success
                    borderColor: '#198754',      // même couleur que fond, sans bordure visible
                    borderWidth: 0,
                    barPercentage: 0.8,          // un peu plus large
                    categoryPercentage: 0.8
                }]
            },
            options: {
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            color: '#212529',
                            font: { size: 14, weight: '600' }
                        },
                        grid: {
                            color: '#e9ecef'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#212529',
                            font: { size: 14, weight: '600' }
                        },
                        grid: { display: false }
                    }
                },
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#333',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        titleFont: { weight: 'bold' },
                        callbacks: {
                            label: ctx => ctx.parsed.x + ' FCFA'
                        }
                    }

                }
            }
        });

    </script>
    <script>
        const ctxClients = document.getElementById('clientsReport').getContext('2d');

        const topClientsChart = new Chart(ctxClients, {
            type: 'bar',
            data: {
                labels: @json($labels), // Ces noms apparaîtront en Y (axe vertical)
                datasets: [{
                    label: 'Total Achats',
                    data: @json($montants), // Ces montants apparaîtront en X (axe horizontal)
                    backgroundColor: 'darkblue', // Bleu foncé
                    borderRadius: 0, // Pas de coins arrondis
                    barThickness: 20
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#333',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        callbacks: {
                            label: ctx => ctx.parsed.x.toLocaleString() + ' FCFA'
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            callback: value => value.toLocaleString() + ' FCFA'
                        }
                    },
                    y: {
                        ticks: {
                            font: {
                                size: 13
                            }
                        }
                    }
                }
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const moisLabels = @json($labelos);
            const montantTotaux = @json($totaux);

            const ctx = document.getElementById('ventesParMoisChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: moisLabels,
                    datasets: [{
                        label: 'Total des ventes par mois',
                        data: montantTotaux,
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        borderWidth: 3,
                        tension: 0.5,
                        fill: true,
                        pointBackgroundColor: '#007bff',
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            labels: { color: '#333' }
                        },
                        tooltip: {
                            backgroundColor: '#343a40',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            callbacks: {
                                label: ctx => ctx.parsed.y.toLocaleString() + ' FCFA'
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: value => value.toLocaleString() + ' FCFA',
                                color: '#212529'
                            },
                            grid: {
                                color: '#e9ecef'
                            }
                        },
                        x: {
                            ticks: {
                                color: '#212529'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
  </body>
</html>
