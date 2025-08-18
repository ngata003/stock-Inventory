
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
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />
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
                  <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="statistics-details d-flex align-items-center justify-content-between">
                            <div>
                              <p class="statistics-title">Nb Coursiers </p>
                              <h3 class="rate-percentage">{{$nb_coursiers}}</h3>
                              <p class="text-danger d-flex"></p>
                            </div>
                            <div>
                              <p class="statistics-title"> Nb Employés </p>
                              <h3 class="rate-percentage">{{$nb_employes}}</h3>
                              <p class="text-success d-flex"></p>
                            </div>
                            <div>
                              <p class="statistics-title"> Nb boutiques </p>
                              <h3 class="rate-percentage">{{$nb_boutiques}}</h3>
                              <p class="text-danger d-flex"></p>
                            </div>
                            <div class="d-none d-md-block">
                              <p class="statistics-title"> Package</p>
                              <h3 class="rate-percentage">{{$package->type_package}}</h3>
                              <p class="text-success d-flex"></p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Boutiques Utilisateurs</h4>
                                <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th> logo </th>
                                        <th> Nom Boutique </th>
                                        <th> Email Boutique </th>
                                        <th> Contact Boutique  </th>
                                        <th> Localisation </th>
                                        <th> site web </th>
                                        <th> Connecté(e) ? </th>
                                        <th> Actions </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($boutiques_admin as $btq )
                                            <tr>
                                                <td class="py-1"> <img src="{{asset('assets/images/'.$btq->logo)}}" alt="image" /></td>
                                                <td> {{$btq->nom_boutique}} </td>
                                                <td> {{$btq->email}} </td>
                                                <td> {{$btq->telephone}} </td>
                                                <td> {{$btq->adresse}} </td>
                                                <td>{{$btq->site_web}}</td>
                                                @if ($btq->status)
                                                    <td class="text-success fw-bold">
                                                        <label class="badge badge-success">✔ Connecté</label>
                                                    </td>
                                                @else
                                                    <td class="text-danger fw-bold">
                                                        <label class="badge badge-danger"> ✖ Non connecté </label>
                                                    </td>
                                                @endif
                                                <td>
                                                    <a href="{{route('statistiques_boutiques',[$btq->id])}}" class="btn btn-success text-white"><i class="fas fa-eye"></i></a>
                                                </td>
                                            </tr>
                                        @empty
                                        <tr>
                                             <td colspan="8" class="text-center text-muted">Aucune boutique crée </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
  </body>
</html>
