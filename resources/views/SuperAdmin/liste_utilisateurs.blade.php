<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
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
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body>
    <div class="container-scroller">
        @include('includes.user_profil_include')
      <div class="container-fluid page-body-wrapper">
        @include('includes.adminNavig')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                      <div>
                        <h4 class="card-title card-title-dash">Espace Utilisateurs  </h4>
                        <p class="card-subtitle card-subtitle-dash"> managez les utilisateurs </p>
                      </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> Nom  </th>
                            <th> Email  </th>
                            <th> Adresse </th>
                            <th> Telephone </th>
                            <th> poste </th>
                            <th> profil </th>
                            <th> connecté(e) ?</th>
                            <th> Piece identité </th>
                            <th colspan="2"> Action </th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ($utilisateurs  as $util )
                                <tr>
                                    <td>{{$util->name}}</td>
                                    <td>{{$util->email}}</td>
                                    <td>{{$util->localisation}}</td>
                                    <td>{{$util->contact }}</td>
                                    <td> {{$util->role}}</td>
                                    @if ($util->profil)
                                        <td><img src="{{asset('assets/images/'.$util->profil)}}" alt=""></td>
                                    @else
                                        <td><img src="{{asset('assets/images/faces/no_profile_picture.png')}}" alt=""></td>
                                    @endif
                                    @if ($util->status_connexion)
                                        <td class="text-success fw-bold">
                                            <label class="badge badge-success">✔ Connecté</label>
                                        </td>
                                    @else
                                        <td class="text-danger fw-bold">
                                            <label class="badge badge-danger"> ✖ Non connecté </label>
                                        </td>
                                    @endif
                                    @if ($util->piece_identite)
                                        <td><img src="{{asset('assets/images/'.$util->piece_identite)}}" alt=""></td>
                                    @else
                                        <td><img src="{{asset('assets/images/faces/no_profile_picture.png')}}" alt=""></td>
                                    @endif
                                    <td>
                                        <a href="{{route('details_admin',[$util->id])}}" class="btn btn-success text-white"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Aucun utilisateur trouvé </td>
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
          @include('includes.footer')
        </div>
      </div>
    </div>
    <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>
  </body>
</html>
