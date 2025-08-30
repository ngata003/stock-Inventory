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
    <link rel="shortcut icon" href="{{asset('assets/images/cames_favIcon.png')}}" />
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  </head>
  <body>
    <div class="container-scroller">
       @include('includes.user_profil_include')
       <div class="container-fluid page-body-wrapper">
       @include('includes.nav_include')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-lg-9 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <div>
                        <h4 class="card-title card-title-dash">Espace Reapprovisionnement </h4>
                        <p class="card-subtitle card-subtitle-dash"> managez vos ajouts de produits en toute aisance</p>
                      </div>
                       <div class="d-flex justify-content-end mb-3 gap-2">
                            <form action="" method="GET" class="d-flex align-items-center position-relative" id="searchForm">
                                <button type="button" id="toggleSearch"class="btn p-2 me-2"
                                    style="background: transparent; border: none; box-shadow: none;">
                                    <i class="mdi mdi-magnify fs-5"></i>
                                </button>
                                <input type="text" name="approv" id="searchInput"
                                class="form-control border-0 border-bottom shadow-none d-none"
                                placeholder=" produit ou fournisseur " aria-label="Search"
                                style="max-width: 200px;">
                            </form>
                            <button class="add btn btn-icons btn-rounded btn-primary todo-list-add-btn text-white me-0 pl-12p"  data-bs-toggle="modal" data-bs-target="#shopModal" type="button"><i class="mdi mdi-plus"></i></button>
                            <div class="dropdown ms-2">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="categoryDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    Choisir un mois
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('approvisionnement', ['mois' => $i]) }}">
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
                                <th> Produit  </th>
                                <th> Fournisseur  </th>
                                <th> Qte Ajoutée  </th>
                                <th> Actions  </th>
                            </tr>
                        </thead>
                        <tbody id="approvTableBody">
                            @forelse ($approvisionnement as $approv )
                                <tr>
                                    <td>{{$approv->produit->nom_produit}}</td>
                                    <td>{{$approv->fournisseur->nom_fournisseur}}</td>
                                    <td>{{$approv->qte_ajoutee}}</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm me-1" data-id="{{$approv->id}}" onclick="openEditModal(this)">  <i class="mdi mdi-pencil"></i> </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-id="{{$approv->id}}" onclick="openSuppModal(this)">  <i class="mdi mdi-trash-can-outline"></i> </button>
                                    </td>
                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Aucun approvisionnement enregistré</td>
                                </tr>
                            @endforelse
                        </tbody>
                       </table>
                       <div class="mt-3 d-flex justify-content-center">
                            {{ $approvisionnement->links('pagination::bootstrap-5') }}
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

    <div class="modal fade" id="shopModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> effectuer un reapprovisionnement   </h5>
                    <button type="button" class="btn text-white fs-4" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{route('add_approvisionnement')}}" enctype="multipart/form-data" id="formulaire" >
                        @csrf
                            <div class="mb-3">
                                <label for="categorie_produit" class="form-label">produit</label>
                                <select name="fk_produit" id="categorie_produit" class="form-select text-dark">
                                    <option value="" id="categorie" selected class="text-dark" >— Sélectionnez une produit —</option>
                                    @foreach ($produits as $prod)
                                        <option value="{{ $prod->id }}" class="text-dark">{{ $prod->nom_produit }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="categorie_produit" class="form-label">fournisseur</label>
                                <select name="fk_fournisseur" id="categorie_produit" class="form-select text-dark">
                                    <option value="" id="categorie" selected class="text-dark" >— Sélectionnez un fournisseur —</option>
                                    @foreach ($fournisseurs as $fournis)
                                        <option value="{{ $fournis->id }}" class="text-dark">{{ $fournis->nom_fournisseur }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="mb-3">
                                <label for="centreName" class="form-label"> qte ajoutée </label>
                                <input type="number" class="form-control" name="qte_ajoutee">
                            </div>
                            <div class="button-container">
                                <button type="submit" id="bouton" class="button btn btn-success" > enregistrer </button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                            </div>
                    </form>
                </div>
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
                    <h5 class="text-danger fw-bold mb-3"> annuler le reapprovisionnement </h5>
                    <p class="text-muted mb-3"> Êtes-vous sûr de vouloir annuler ce reapprovisionnement ? </p>
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

    <div class="modal fade" id="deleterModal" tabindex="-1" aria-labelledby="deleterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-trash-can-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('approv_delete'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('approv_delete')}}</h5>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-primary shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-pencil-circle-outline mdi-48px text-primary animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('approv_updated'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('approv_updated')}}</h5>
                    @endif
                    <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-dismiss="modal">
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
                    @if(session('approv_success'))
                        <h5 class="text-success fw-bold mb-2">{{ session('approv_success') }}</h5>
                    @endif
                    <button type="button" class="btn btn-success btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content border-danger shadow-lg">
                    <div class="modal-body text-center p-4">
                        <div class="mb-3">
                            <i class="mdi mdi-alert-circle-outline mdi-48px text-danger animate__animated animate__zoomIn"></i>
                        </div>
                        <h5 class="text-danger fw-bold mb-3">Erreur(s) détectée(s)</h5>
                        <ul class="text-start text-danger small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script src="{{asset('assets/vendors/js/vendor.bundle.base.j')}}s"></script>
    <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('ssets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>

    <script>
        const deleteApprovUrl =@json(route('annuler_approvisionnement', ['id' => '__ID__'])) ;
        function openSuppModal(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('deleteForm').action = deleteApprovUrl.replace('__ID__', id);
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('approv_delete'))
            var deleterModal = new bootstrap.Modal(document.getElementById('deleterModal'));
            deleterModal.show();
        @endif
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('approv_updated'))
            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
        @endif
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('approv_success'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        @endif
        });
    </script>

    <script>
        function openEditModal(button) {

            var id = button.getAttribute('data-id');
            var nom = button.getAttribute('data-nom');
            var description = button.getAttribute('data-description')
            const updateCategorieUrl = @json(route('update_categories', ['id' => '__ID__']));


            document.getElementById('editModalLabel').textContent = ' Modifier une categorie ';
            document.getElementById('editForm').action = updateCategorieUrl.replace('__ID__', id);
            document.getElementById('categorie').value = nom;
            document.getElementById('description').value = description;

            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();

        }

    </script>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
                errorModal.show();
            });
        </script>
    @endif

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
                    url: "{{ route('approvisionnement') }}",
                    type: "GET",
                    data: { approv: query },
                    success: function (data) {
                        let newTbody = $(data.html).find('#approvTableBody').html();
                        $('#approvTableBody').html(newTbody);
                    },
                    error: function () {
                        alert("Erreur lors du chargement des approvisionnements");
                    }
                });
            }
        });
    </script>

  </body>

</html>
