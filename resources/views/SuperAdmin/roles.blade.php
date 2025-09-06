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
       @include('includes/user_profil_include')
      <div class="container-fluid page-body-wrapper">
       @include('includes.adminNavig')
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-8 d-flex flex-column">
                    <div class="row flex-grow">
                        <div class="col-10 grid-margin stretch-card">
                            <div class="card card-rounded">
                                <div class="card-body">
                                  <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                     <h4 class="card-title card-title-dash">Espace Roles </h4>
                                     <p class="card-subtitle card-subtitle-dash">managez les roles en toute aisance</p>
                                    </div>
                                    <div class="d-flex justify-content-end mb-3 gap-2">
                                        <form action="" method="GET" class="d-flex align-items-center position-relative" id="searchForm">
                                            <button type="button" id="toggleSearch"class="btn p-2 me-2"
                                                style="background: transparent; border: none; box-shadow: none;">
                                                <i class="mdi mdi-magnify fs-5"></i>
                                            </button>
                                            <input type="text" name="role" id="searchInput"
                                            class="form-control border-0 border-bottom shadow-none d-none"
                                            placeholder=" entrez un nom " aria-label="Search"
                                            style="max-width: 200px;">
                                        </form>
                                        <button class="add btn btn-icons btn-rounded btn-primary todo-list-add-btn text-white me-0 pl-12p" data-bs-toggle="modal" data-bs-target="#shopModal" type="button"><i class="mdi mdi-plus"></i></button>
                                    </div>
                                  </div>
                                  <div class="table-responsive mt-1">
                                    <table class="table select-table">
                                        <thead>
                                            <tr>
                                                <th> Nom  </th>
                                                <th> Action </th>
                                            </tr>
                                        </thead>
                                      <tbody id="rolesTableBody">
                                        @forelse ($roles as $rol )
                                            <tr>
                                                <td>{{$rol->nom}}</td>
                                                <td>
                                                    <button type="button" class="btn btn-success btn-sm me-1" data-id="{{$rol->id}}" data-nom="{{$rol->nom}}" onclick="openEditModal(this)"> <i class="mdi mdi-pencil"></i> </button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-id="{{$rol->id}}" onclick="openSuppModal(this)"> <i class="mdi mdi-trash-can-outline"></i> </button>
                                                </td>
                                            </tr>
                                        @empty
                                        <tr>
                                            <td colspan="2" class="text-center text-muted">Aucun role enregistré</td>
                                        </tr>
                                        @endforelse
                                      </tbody>
                                    </table>
                                    <div class="mt-3 d-flex justify-content-center">
                                        {{ $roles->links('pagination::bootstrap-5') }}
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

    <div class="modal fade" id="shopModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Ajouter une role   </h5>
                    <button type="button" class="btn text-white fs-4" data-bs-dismiss="modal" aria-label="Close">&times;</button>
                </div>

                <div class="modal-body">
                    <form method="POST" action="{{route('add_roles')}}" enctype="multipart/form-data" id="formulaire" >
                        @csrf
                            <div class="mb-3">
                                <label for="centreName" class="form-label">Nom role </label>
                                <input type="text" name="nom" class="form-control" id="" placeholder="entrer le role ex: admin, vendeur ">
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

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"> Modifier les informations des roles   </h5>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data"  action="" id="editForm" >
                        @csrf
                        @method('PUT')

                            <div class="mb-3">
                                <label for="centreName" class="form-label">Nom role </label>
                                <input type="text" name="nom" class="form-control" id="nom_role" placeholder="entrer le role ex: admin, vendeur ">
                            </div>
                            <div class="button-container ">
                                <button type="submit" id="bouton" class="button btn btn-success" > Modifier </button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Fermer </button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Supprimer le role </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Êtes-vous sûr de vouloir supprimer ce role ?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
              <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Oui</button>
              </form>
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
                    @if(session('role_deleted'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('role_deleted')}}</h5>
                    @endif
                    <button type="button" class="btn btn-danger btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>


        <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-success shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-check-circle-outline mdi-48px text-success animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('role_creation'))
                        <h5 class="text-success fw-bold mb-2">{{ session('role_creation') }}</h5>
                    @endif
                    <button type="button" class="btn btn-success btn-sm mt-3" data-bs-dismiss="modal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de succès après édition -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-primary shadow-lg">
                <div class="modal-body text-center p-4">
                    <div class="mb-3">
                        <i class="mdi mdi-pencil-circle-outline mdi-48px text-primary animate__animated animate__zoomIn"></i>
                    </div>
                    @if(session('role_updated'))
                        <h5 class="modal-title" id="deleterModalLabel">{{session('role_updated')}}</h5>
                    @endif
                    <button type="button" class="btn btn-primary btn-sm mt-3" data-bs-dismiss="modal">
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

    <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/template.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('ssets/js/hoverable-collapse.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>
    <script>
        function openEditModal(button) {

            var id = button.getAttribute('data-id');
            var nom = button.getAttribute('data-nom');
            const updateRoleUrl = @json(route('update_roles', ['id' => '__ID__']));


            document.getElementById('editModalLabel').textContent = ' Modifier un role ';
            document.getElementById('editForm').action = updateRoleUrl.replace('__ID__', id);
            document.getElementById('nom_role').value = nom;

            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();

        }

    </script>

    <script>

        const deleteRolesUrl =@json(route('delete_roles', ['id' => '__ID__'])) ;
        function openSuppModal(button) {
            var id = button.getAttribute('data-id');
            document.getElementById('deleteForm').action = deleteRolesUrl.replace('__ID__', id);
            var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('role_deleted'))
            var deleterModal = new bootstrap.Modal(document.getElementById('deleterModal'));
            deleterModal.show();
        @endif
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('role_creation'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        @endif
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('role_updated'))
            var updateModal = new bootstrap.Modal(document.getElementById('updateModal'));
            updateModal.show();
        @endif
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(session('error_nb_coursier'))
            var NbModal = new bootstrap.Modal(document.getElementById('errorNbModal'));
            NbModal.show();
        @endif
        });
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
                    url: "{{ route('roles') }}",
                    type: "GET",
                    data: { role: query },
                    success: function (data) {
                        let newTbody = $(data.html).find('#rolesTableBody').html();
                        $('#rolesTableBody').html(newTbody);
                    },
                    error: function () {
                        alert("Erreur lors du chargement des roles");
                    }
                });
            }
        });
    </script>

  </body>

</html>
