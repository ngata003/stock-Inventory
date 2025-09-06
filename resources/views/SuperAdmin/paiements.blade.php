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
                            <h4 class="card-title card-title-dash">Espace Paiements </h4>
                            <p class="card-subtitle card-subtitle-dash"> managez les abonnements </p>
                        </div>
                        <div class="d-flex justify-content-end mb-3 gap-2">
                            <form action="" method="GET" class="d-flex align-items-center position-relative" id="searchForm">
                                <button type="button" id="toggleSearch"class="btn p-2 me-2"
                                    style="background: transparent; border: none; box-shadow: none;">
                                    <i class="mdi mdi-magnify fs-5"></i>
                                </button>
                                <input type="text" name="abonnement" id="searchInput"
                                class="form-control border-0 border-bottom shadow-none d-none"
                                placeholder=" entrez un nom " aria-label="Search"
                                style="max-width: 200px;">
                            </form>
                            <a href="{{ route('export.paiements') }}" class="btn btn-success">
                                Exporter en Excel
                            </a>
                            <div class="dropdown ms-2">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="categoryDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    Choisir un mois
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('liste_paiements', ['mois' => $i]) }}">
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
                            <th> Action </th>
                          </tr>
                        </thead>
                        <tbody id="abonnementsTableBody">
                            @forelse ($paiements  as $pay )<tr>
                            <td >{{$pay->nom_depositaire}}</td>
                            <td>{{$pay->montant}}</td>
                            <td>{{$pay->packages->type_package}}</td>
                            <td>{{$pay->createurs->name}}</td>
                            @if ($pay->statut === "valide")
                                <td class="text-success fw-bold">
                                    <label class="badge badge-success">✔ payé</label>
                                </td>
                            @else
                                <td class="text-danger fw-bold">
                                    <label class="badge badge-warning"> … En attente </label>
                                </td>
                            @endif
                            <td>{{$pay->date_paiement}}</td>
                            <td>
                              <button type="button" class="btn btn-danger btn-sm me-1" data-id="{{$pay->id}}" onclick="openSuppModal(this)"> <i class="mdi mdi-trash-can-outline"></i> </button>
                              <button type="button" class="btn btn-success btn-sm" data-id="{{$pay->id}}" data-auth="{{$pay->userid}}" onclick="openValidModal(this)"><i class="mdi mdi-check-circle-outline"></i></button>
                            </td>
                          </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Aucun paiement enregistré</td>
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

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-alert-circle-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                    <h5 class="text-danger fw-bold mb-3">Supprimer le produit ?</h5>
                    <p class="text-muted mb-3">Êtes-vous sûr de vouloir supprimer ce produit ?</p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Non</button>
                        <form method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Oui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="validModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-success shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-check-circle-outline mdi-48px text-success animate__animated animate__zoomIn"></i>
                    </div>
                    <h5 class="text-dark fw-bold mb-3"> valider le paiement ?</h5>
                    <p class="text-muted mb-3"> Êtes-vous sûr de vouloir valider ce paiement? </p>
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Non</button>
                        <form method="POST" id="validForm">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success btn-sm">Oui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleterModal" tabindex="-1" aria-labelledby="deleterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-trash-can-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('pay_deleted'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('pay_deleted')}}</h5>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-success shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-check-circle-outline mdi-48px text-success animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('success_pay'))
                        <h5 class="text-success fw-bold mb-2">{{ session('success_pay') }}</h5>
                    @endif
                    <button type="button" class="btn btn-success btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
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

        const deletePayUrl =@json(route('delete_paiement', ['id' => '__ID__'])) ;
        function openSuppModal(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('deleteForm').action = deletePayUrl.replace('__ID__', id);
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

    <script>

        const validPayUrl =@json(route('valider_paiement', ['id' => '__ID__'])) ;
        function openValidModal(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('validForm').action = validPayUrl.replace('__ID__', id);
            var validModal = new bootstrap.Modal(document.getElementById('validModal'));
            validModal.show();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('pay_deleted'))
            var deleterModal = new bootstrap.Modal(document.getElementById('deleterModal'));
            deleterModal.show();
        @endif
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('success_pay'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        @endif
        });

    </script>

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
                    url: "{{ route('liste_paiements') }}",
                    type: "GET",
                    data: { abonnement: query },
                    success: function (data) {
                        let newTbody = $(data.html).find('#abonnementsTableBody').html();
                        $('#abonnementsTableBody').html(newTbody);
                    },
                    error: function () {
                        alert("Erreur lors du chargement des produits");
                    }
                });
            }
        });
    </script>

  </body>
</html>
