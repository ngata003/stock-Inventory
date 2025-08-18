<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> CAMES  </title>

    <link rel="stylesheet" href="{{asset('assets/vendors/feather/feather.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/ti-icons/css/themify-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/typicons/typicons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/simple-line-icons/css/simple-line-icons.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

  </head>
  <body>
    <div class="container-scroller">
       @include('includes.user_profil_include')
      <div class="container-fluid page-body-wrapper">
      @include('superAdmin.includes_nav')
        <div class="main-panel">
          <div class="content-wrapper">

            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                        <div>
                          <h4 class="card-title card-title-dash"> Espace Boutiques </h4>
                          <p class="card-subtitle card-subtitle-dash"> managez votre boutique en toute aisance  </p>
                        </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> Nom Boutique </th>
                            <th> Email </th>
                            <th> Telephone </th>
                            <th> Localisation </th>
                            <th> Site web </th>
                            <th> Logo</th>
                            <th> Connectée ? </th>
                            <th> actions </th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ($inf_boutiques as $inf_store)
                                <tr>
                                    <td > {{$inf_store->nom_boutique }}</td>
                                    <td> {{$inf_store->email}} </td>
                                    <td> {{$inf_store->telephone}} </td>
                                    <td> {{$inf_store->adresse}} </td>
                                    <td> {{$inf_store->site_web}} </td>
                                    <td> <img src="{{asset('assets/images/'.$inf_store->logo)}}" alt=""> </td>
                                    @if ($inf_store->connecte)
                                        <td class="text-success fw-bold">
                                            <label class="badge badge-success">✔ Connecté</label>
                                        </td>
                                    @else
                                        <td class="text-danger fw-bold">
                                            <label class="badge badge-danger"> ✖ Non connecté </label>
                                        </td>
                                    @endif
                                    <td>
                                        <a href="{{route('boutique_details',[$inf_store->id])}}" class="btn btn-success text-white"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Aucune boutique trouvée</td>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
