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
    <link rel="shortcut icon" href="{{asset('assets/images/cames_favIcon.png')}}"/>
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
                        <div class="d-flex justify-content-end mb-3 gap-2">
                            <form action="" method="GET" class="d-flex align-items-center position-relative" id="searchForm">
                                <button type="button" id="toggleSearch"class="btn p-2 me-2"
                                    style="background: transparent; border: none; box-shadow: none;">
                                    <i class="mdi mdi-magnify fs-5"></i>
                                </button>
                                <input type="text" name="admin" id="searchInput"
                                class="form-control border-0 border-bottom shadow-none d-none"
                                placeholder=" entrez un nom " aria-label="Search"
                                style="max-width: 200px;">
                            </form>
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
                        <tbody id="adminTableBody">
                            @forelse ($utilisateurs  as $util )
                                <tr>
                                    <td>{{$util->name}}</td>
                                    <td>{{$util->email}}</td>
                                    <td>{{$util->adresse}}</td>
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
                                        <a href="{{route('details_admin',[$util->id])}}" class="btn btn-success btn-sm me-1 text-white"><i class="fas fa-eye"></i></a>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleBtn = document.getElementById("toggleSearch");
            const searchInput = document.getElementById("searchInput");
            const searchForm = document.getElementById("searchForm");

            // toggle au clic sur la loupe
            toggleBtn.addEventListener("click", function (e) {
                e.stopPropagation(); // empêche le clic de se propager au document
                searchInput.classList.toggle("d-none");
                if (!searchInput.classList.contains("d-none")) {
                    searchInput.focus(); // focus automatique
                }
            });

            // si on clique ailleurs → fermer input
            document.addEventListener("click", function(e) {
                if (!searchForm.contains(e.target)) {
                    searchInput.classList.add("d-none");
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#searchInput').on('keyup', function () {
                let query = $(this).val();
                fetchProducts(query);
            });

            function fetchProducts(query = '') {
                $.ajax({
                    url: "{{ route('liste_utilisateurs') }}",
                    type: "GET",
                    data: { admin: query },
                    success: function (data) {
                        let newTbody = $(data.html).find('#adminTableBody').html();
                        $('#adminTableBody').html(newTbody);
                    },
                    error: function () {
                        alert("Erreur lors du chargement des propriétaires");
                    }
                });
            }
        });
    </script>
  </body>
</html>
