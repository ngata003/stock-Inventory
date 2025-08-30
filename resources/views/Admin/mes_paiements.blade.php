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
    <style>
        #toggleSearch {
            height: calc(1.5em + .75rem + 2px); /* hauteur standard Bootstrap btn */
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
        @include('includes.user_profil_include')
      <div class="container-fluid page-body-wrapper">
        @include('includes/nav_include')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-sm-flex justify-content-between align-items-start">
                      <div>
                        <h4 class="card-title card-title-dash"> Mes Paiements </h4>
                        <p class="card-subtitle card-subtitle-dash"> verifiez vos paiements  </p>
                       </div>
                        <div class="d-flex justify-content-end mb-3 gap-2">
                            <form action="{{ route('statistiques') }}" method="GET"
                                class="d-flex align-items-center position-relative" id="searchForm">
                                <button type="button" id="toggleSearch"
                                        class="btn p-2 me-2"
                                        style="background: transparent; border: none; box-shadow: none;">
                                    <i class="mdi mdi-magnify fs-5"></i>
                                </button>
                                <input type="text" name="q" id="searchInput"
                                    class="form-control border-0 border-bottom shadow-none d-none"
                                    placeholder="Search Here" aria-label="Search"
                                    style="max-width: 200px;">
                            </form>
                            <div class="dropdown ms-2">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="categoryDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    Choisir un mois
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('mes_paiements', ['mois' => $i]) }}">
                                                {{ \Carbon\Carbon::create()->month($i)->locale('fr')->monthName }}
                                            </a>
                                        </li>
                                    @endfor
                                </ul>
                            </div>
                       </div>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th> Nom depositaire  </th>
                            <th> Montant package   </th>
                            <th> package  </th>
                            <th> utilisateur </th>
                            <th> status </th>
                            <th> date paiement </th>
                            <th> date expiration </th>
                          </tr>
                        </thead>
                        <tbody>
                            @forelse ($paiements  as $pay )<tr>
                            <td >{{$pay->nom_depositaire}}</td>
                            <td>{{$pay->montant}}</td>
                            <td>{{$pay->packages->type_package}}</td>
                            <td>{{$pay->createurs->name}}</td>
                            @if ($pay->statut)
                                <td class="text-success fw-bold">
                                    <label class="badge badge-success">✔ payé</label>
                                </td>
                            @else
                                <td class="text-danger fw-bold">
                                    <label class="badge badge-danger"> ✖ Non payé </label>
                                </td>
                            @endif
                            <td>{{$pay->date_paiement}}</td>
                            <td>{{$pay->date_expiration}}</td>
                          </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Aucun paiement enregistré</td>
                                </tr>
                            @endforelse
                        </tbody>
                      </table>
                      <div class="mt-3 d-flex justify-content-center">
                        {{ $paiements->links('pagination::bootstrap-5') }}
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

    <script src="{{asset('assets/vendors/js/vendor.bundle.base.j')}}s"></script>
    <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('ssets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
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
  </body>
</html>
